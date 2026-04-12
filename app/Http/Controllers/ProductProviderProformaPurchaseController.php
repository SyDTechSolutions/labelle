<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductProvider;
use Illuminate\Http\Request;
use App\ProformaPurchase;
use App\Provider;
use App\Rules\UniquePurchase;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ProductProviderProformaPurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductProvider $productprovider)
    {
        $proformasGeneradas = 0;
        $lines = $productprovider->lines;
        $providerIds = [];

        foreach($lines as $line){
           $ids = array_pluck($line->providers, "id");
           $providerIds = array_merge($providerIds, $ids);
          
           $colletionProviders = collect($line->providers);

           if($colletionProviders->count()){

            $precioBajo = $colletionProviders->min('price');

            $proveedorConPrecioBajo = $colletionProviders->where('price',  $precioBajo)->first();
            
            $product = Product::where('code', $line->Codigo)->first();
            $line->provider_id = $proveedorConPrecioBajo["id"];
            $line->PrecioUnitario = $proveedorConPrecioBajo["price"];
            $line->precioUnidad = $proveedorConPrecioBajo["price"];
            $line->UnidadMedida = "Unid";
            $line->unidades =  $line->Cantidad;
            
            $taxes = [];
            foreach($product->taxes as $productTax){
                    $taxes [] = [
                        "code" => $productTax->code,
                        "name" => $productTax->name,
                        "tarifa" => $productTax->tarifa,
                        "CodigoTarifa" => $productTax->CodigoTarifa,
                        "amount" => 0,
                        "TarifaOriginal" => $productTax->tarifa,
                        
                    ];

            }
            
            $line->taxes = $taxes;

           }
           
        
        }

        foreach(array_unique($providerIds) as $providerId){

            $provider = Provider::find($providerId);;
            $data['provider_id'] = $providerId;
            $data['TipoDocumento'] = "01";
            $data['fecha_factura'] = Carbon::now();
            $data['TotalComprobante'] = 0;
            $data['cliente'] = $provider->name;
            $data['email'] = $provider->email;

            $data = $this->prepareData($data);

            $data['lines'] = $this->prepareLines($lines->toArray(), $providerId);
            
            
            if(count($data['lines'])){
                $proformapurchase = ProformaPurchase::create($data);
                $proformapurchase = $proformapurchase->saveLines($data['lines']);
                $proformasGeneradas++;
            }
           

           


            
         }
       
        return $proformasGeneradas;

    }

    private function prepareLines($lines, $providerId)
    {
        $result = [];

        foreach($lines as $line){
            if($line['provider_id'] == $providerId){
                $result[] = $line;
            }
        }
        return $result;
    }


    private function prepareData($data, $obligadoTributario = null)
    {

        $data['consecutivo'] = $this->crearConsecutivo($data['TipoDocumento']);

    
        if ($data['TipoDocumento'] != '01') {
            $data = Arr::except($data, array('id'));
        }

        //if($data['CondicionVenta'] == '02'){ //credito
            $data['cxp_pending_amount'] = $data['TotalComprobante'];
       // }
       $data['created_by'] = isset($data['created_by']) ? $data['created_by'] : auth()->id();

        return $data;
    }

    public function crearConsecutivo($tipoDocumento)
    {
      

        $consecutivo_inicio = 1;


        $consecutivo = ProformaPurchase::where('TipoDocumento', $tipoDocumento)->max('consecutivo');


        return ($consecutivo) ? $consecutivo += 1 : $consecutivo_inicio;
    }

   
}
