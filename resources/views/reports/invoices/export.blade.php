<table class="table">
    <thead>
        <tr>
            <th scope="col">Consecutivo</th>
            <th scope="col">Código Actividad Emisor</th>
            <th scope="col">Código Actividad Receptor</th>
            <th scope="col">Moneda Utilizada</th>
            <th scope="col">Tipo</th>
            <th scope="col" title="Tiene Nota de Crédito o Débito">NC / ND</th>
            <th scope="col">Fecha</th>
            <th scope="col">Identificación</th>
            <th scope="col">Cliente</th>
            <th scope="col">Metodo de Pago</th>
            <th scope="col">IVA 1%</th>
            <th scope="col">IVA 2%</th>
            <th scope="col">IVA 4%</th>
            <th scope="col">IVA 13%</th>
            <th scope="col">Total IVA</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Total</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $invoice)

            <tr>

                <th scope="row">
                    {{ $invoice['consecutivo']}}
                </th>

                <td>{{ $invoice['CodigoActividadEmisor'] }}</td>

                <td>{{ $invoice['CodigoActividadReceptor'] }}</td>

                <td>{{ $invoice['CodigoMoneda'] }}</td>

                <td>{{ $invoice['TipoDocumentoName'] }}</td>

                <td>{{ $invoice['TipoDocumento'] == '02' || $invoice['TipoDocumento'] == '03' ? 'Sí' : 'No' }}</td>

                <td>{{ $invoice['created_at']}}</td>

                <!-- <td>{{ $invoice['CondicionVenta'] == '02' ? 'Sí' : 'No' }}</td> -->

                <td>{{ $invoice['identificacion_cliente'] }}</td>

                <td>{{ $invoice['cliente'] }}</td>

                <td>{{ $invoice['MedioPagoName'] }}</td>

                <td>{{$invoice['uno'] }}</td>

                <td>{{ $invoice['dos'] }}</td>

                <td>{{ $invoice['cuatro'] }}</td>

                <td>{{ $invoice['trece'] }}</td>

                <td>

                    {{ $invoice['TotalImpuesto']}}

                </td>

                <td>{{ $invoice['TotalVentaNeta'] }}</td>

                <td>

                    @if($invoice['canceled'])

                        {{ $invoice['TotalComprobante'] }}

                    @else

                        {{ $invoice['TotalWithNota'] }}

                    @endif

                </td>

            </tr>

        @endforeach
        <tr>
            
            <td colspan="11" class="text-right">
                <b>Efectivo:</b> {{  $TotalEfectivo }}
            </td>
            <td class="text-right">
                <b>Caja Inicial:</b>
            </td>
            <td>
                {{  money($amountCaja) }}
            </td>
        </tr>
        <tr>
            
            <td colspan="11" class="text-right">
                <b> Tarjeta:</b> {{  $TotalTarjeta }}
            </td>
            <td class="text-right">
                <b> Total Ventas:</b>
            </td>
            <td>
                {{  $totalVentas }}
            </td>
        </tr>
        
        <tr>
            
            <td colspan="11" class="text-right">
                <b> Transferencia:</b> {{  $TotalDeposito }}
            </td>
            <td class="text-right">
                <b> Impuestos:</b>
            </td>
            <td>
                {{  $totalTaxes }}
            </td>
        </tr>

        <tr>
                <td colspan="13" class="text-right">
                <b> Total:</b> {{  $totalReporte }}
            </td>
        </tr>
    
    </tbody>
</table> 