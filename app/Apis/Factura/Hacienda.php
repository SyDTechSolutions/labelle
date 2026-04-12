<?php

namespace App\Apis\Factura;
use App\ConfigFactura;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class Hacienda
{
    private $apiUrl;
    private $api_env;
    public function __construct()
    {
        // Constructor logic if needed
        $this->api_env = config('api.environment', 'sandbox');
        $this->apiUrl = config("api.factura.$this->api_env.url");

    }

    public function sendDocument($invoiceData)
    {
        // Logic to send invoice data to Hacienda
        $empresa = ConfigFactura::first();
        $body = $this->prepareData($invoiceData,$empresa);
        $token = $this->getToken($empresa);
        $response = Http::withToken($token)->post($this->apiUrl.'/enviar/'.$empresa->identificacion, $body);

        return $response->json();
    }   

    public function getXMLResponse($clave){
        $empresa = ConfigFactura::first();
        $data = array(
            'numero_identidad' => $empresa->identificacion,
            'clave_comprobante' => $clave,
        );
        $token = $this->getToken($empresa);
        $response = Http::withToken($token)->post($this->apiUrl.'/consultar/respuesta', $data);

        if ($response->failed()) {
            \Log::error('Error al consultar la respuesta de Hacienda', ['clave' => $clave, 'status' => $response->status()]);
            return null;
        }
        
        return $response->json();
    }


    private function prepareData($invoiceData, $empresa)
    {
        $totalDesgloseImpuesto = $this->agruparDesgloseImpuestos($invoiceData->lines);
        $hasImpuestos = !empty($totalDesgloseImpuesto);

        $data = [
            "TipoComprobante" => $invoiceData->TipoDocumento,
            "ProveedorSistemas"=> '504200201',
            "CodigoActividadEmisor" => $empresa->CodigoActividad,
            "Receptor" => [
                "CodigoActividadReceptor" => $invoiceData->CodigoActividadReceptor,
                "Nombre" => $invoiceData->cliente ?? '000000000',
                "Identificacion" => [
                    "Numero" => $invoiceData->identificacion_cliente ?? $empresa->identificacion,
                    "Tipo" => $invoiceData->tipo_identificacion_cliente ?? $empresa->tipo_identificacion
                ],
                "CorreoElectronico" => $invoiceData->email ?? $empresa->email
            ],
            "CondicionVenta" => $invoiceData->CondicionVenta,
            "MedioPago" => $invoiceData->MedioPago,
            "DetalleServicio" => collect($invoiceData->lines)->map(function ($line, $index) {
                return [
                    "NumeroLinea" => $index + 1,
                    "CodigoCabbys" => $line['CodigoProductoHacienda'],
                    "CodigoComercial" => [
                        [
                            "Tipo" => "01",
                            "Codigo" => $line['Codigo']
                        ]
                    ],
                    "Cantidad" => (float)$line['Cantidad'],
                    "UnidadMedida" => $line['UnidadMedida'],
                    "UnidadMedidaComercial" => "",
                    "Detalle" => substr($line['Detalle'], 0, 150),
                    "PrecioUnitario" => number_format($line['PrecioUnitario'], 5, '.', ''),
                    "MontoTotal" => number_format($line['MontoTotal'], 5, '.', ''),
                    "SubTotal" => number_format($line['SubTotal'], 5, '.', ''),
                    "BaseImponible" => number_format($line['BaseImponible'], 5, '.', ''),
                    "Impuesto" => collect($line['taxes'])->map(function ($tax) use ($line) {
                        $impuestoData = [
                            "Codigo" => $tax['code'],
                            "CodigoTarifa" => $tax['CodigoTarifa'] ?? '08',
                            "Tarifa" => number_format($tax['tarifa'], 2, '.', ''),
                            "Monto" => number_format($tax['amount'], 5, '.', '')
                        ];
                        if($tax['code'] == '99') {
                            $impuestoData['CodigoImpuestoOTRO'] = $tax['name'];
                        }  

                        if($line['exo'] > 0) {
                            $impuestoData['Exoneracion'] = [
                                "TipoDocumentoEX1" => $tax['TipoDocumento'],
                                "NumeroDocumento" => $tax['NumeroDocumento'],
                                "NombreInstitucion" => $tax['NombreInstitucion'],
                                "FechaEmision" => \Carbon\Carbon::parse($tax['FechaEmision'])->format('Y-m-d\TH:i:s'),
                                "MontoExoneracion" => number_format($tax['MontoExoneracion'], 5, '.', ''),
                                "PorcentajeExoneracion" => number_format($tax['PorcentajeExoneracion'], 2, '.', '')
                            ];
                        }
                        return $impuestoData;
                    })->all(),
                    "Descuento" => [
                        [
                            "MontoDescuento" => number_format(isset($line['MontoDescuento']) ? (float)$line['MontoDescuento'] : 0, 5, '.', ''),
                            "CodigoDescuento" => '07'
                        ]
                    ],
                    "ImpuestoNeto" => number_format($line['totalTaxes'], 5, '.', ''),
                    "MontoTotalLinea" => number_format($line['MontoTotalLinea'], 5, '.', '')
                ];
            })->all(),
            "ResumenFactura" => [
                "CodigoTipoMoneda" => [
                    "CodigoMoneda" => $invoiceData->CodigoMoneda,
                    "TipoCambio" => number_format($invoiceData->TipoCambio, 5, '.', '')
                ],
                "TotalServGravados" => number_format($invoiceData->TotalServGravados, 5, '.', ''),
                "TotalServExentos" => number_format($invoiceData->TotalServExentos, 5, '.', ''),
                "TotalServExonerado" => number_format($invoiceData->TotalServExonerado, 5, '.', ''),
                "TotalServNoSujeto" => "0.00000",
                "TotalMercanciasGravadas" => number_format($invoiceData->TotalMercanciasGravadas, 5, '.', ''),
                "TotalMercanciasExentas" => number_format($invoiceData->TotalMercanciasExentas, 5, '.', ''),
                "TotalMercExonerada" => number_format($invoiceData->TotalMercExonerada, 5, '.', ''),
                "TotalMercNoSujeta" => "0.00000",
                "TotalGravado" => number_format($invoiceData->TotalGravado, 5, '.', ''),
                "TotalExento" => number_format($invoiceData->TotalExento, 5, '.', ''),
                "TotalExonerado" => number_format($invoiceData->TotalExonerado, 5, '.', ''),
                "TotalNoSujeto" => "0.00000",
                "TotalVenta" => number_format($invoiceData->TotalVenta, 5, '.', ''),
                "TotalDescuentos" => number_format($invoiceData->TotalDescuentos, 5, '.', ''),
                "TotalVentaNeta" => number_format($invoiceData->TotalVentaNeta, 5, '.', ''),
                ] + ($hasImpuestos ? ["TotalDesgloseImpuesto" => $totalDesgloseImpuesto] : []) + [
                "TotalImpuesto" => number_format($invoiceData->TotalImpuesto, 5, '.', ''),
                "TotalIVADevuelto" => number_format($invoiceData->TotalIVADevuelto, 5, '.', ''),
                "MedioPago" => [
                    [
                        "TipoMedioPago" => $invoiceData->MedioPago,
                        "TotalMedioPago" => number_format($invoiceData->TotalComprobante, 5, '.', '')
                    ]
                ],
                "TotalComprobante" => number_format($invoiceData->TotalComprobante, 5, '.', '')
            ],
            "InformacionReferencia" => collect($invoiceData->referencias)->map(function ($ref) {
                return [
                    "TipoDocIR" => $ref['TipoDocumento'],
                    "Numero" => $ref['NumeroDocumento'],
                    "FechaEmisionIR" => \Carbon\Carbon::parse($ref['FechaEmision'])->format('Y-m-d\TH:i:s'),
                    "Codigo" => $ref['CodigoReferencia'],
                    "Razon" => $ref['Razon']
                ];
            })->all(),
            "otros" => [
                "OtroTexto" => [
                    [
                        "Nombre" => "Observaciones",
                        "Valor" => $invoiceData->observations ?? ''
                    ],
                    [
                        "Nombre" => "FormaPago",
                        "Valor" => $invoiceData->pay_with == 0 ? "Efectivo" : "Otro"
                    ]
                ]
            ]
        ];

        if($invoiceData->CondicionVenta == '02'){
            $data['PlazoCredito'] = $this->calcularDiasPlazoCredito($invoiceData->PlazoCredito);
        }

        return $data;
    }

    private function agruparDesgloseImpuestos($lines)
    {
        $result = [];
        foreach ($lines as $line) {
            foreach ($line['taxes'] as $tax) {
                $codigo = $tax['code'] ?? '01';
                $codigoTarifa = $tax['CodigoTarifa'] ?? '08';
                $monto = isset($tax['amount']) ? (float)$tax['amount'] : 0;
                $key = $codigo . '-' . $codigoTarifa;

                if (!isset($result[$key])) {
                    $result[$key] = [
                        'Codigo' => $codigo,
                        'CodigoTarifaIVA' => $codigoTarifa,
                        'TotalMontoImpuesto' => 0
                    ];
                }

                $result[$key]['TotalMontoImpuesto'] += $monto;
            }
        }

        // Formatear los montos
        foreach ($result as &$item) {
            $item['TotalMontoImpuesto'] = number_format($item['TotalMontoImpuesto'], 5, '.', '');
        }
        return array_values($result);
    }

    /**
     * Calcula el número de días entre la fecha actual (America/Costa_Rica) y la fecha de plazo de crédito
     */
    private function calcularDiasPlazoCredito($fechaPlazo)
    {
        if (empty($fechaPlazo)) {
            return 0;
        }
        $hoy = \Carbon\Carbon::now('America/Costa_Rica')->startOfDay();
        $fechaLimite = \Carbon\Carbon::parse($fechaPlazo, 'America/Costa_Rica')->startOfDay();
        $dias = $hoy->diffInDays($fechaLimite, false);
        return max($dias, 0);
    }  
    
    protected function getToken($empresa)
    {
        if(!Cache::has('access_token')) {
            Cache::forget('access_token');
            // cpf-05-0420-0201@stag.comprobanteselectronicos.go.cr
            // i@z>L.+}EXA:>Qz+hNnO
            $data = array(
                'username' => $this->api_env == 'sandbox' ? 'cpf-01-0915-0337@stag.comprobanteselectronicos.go.cr' : $empresa->atv_user,
                'password' => $this->api_env == 'sandbox' ? 'b|a-1;UK:bv#E]j]j)r0' : $empresa->atv_password,
            );

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl.'/auth/login', $data);
            $token_data = $response->object();
            \Log::info(isset($token_data->token) ? 'Token OK' : 'No Token generado');
            Cache::add('access_token', $token_data->token, 36000);
        }
        return Cache::get('access_token');
    }
}
