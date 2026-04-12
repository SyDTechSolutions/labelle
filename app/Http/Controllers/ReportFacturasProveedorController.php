<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\PurchaseLine;
use Carbon\Carbon;

class ReportFacturasProveedorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search['type'] = request('type');
        $search['q'] = request('q');
        $search['condicion'] = request('condicion');
        $search['MedioPago'] = request('MedioPago');
        $search['start'] = request('start');
        $search['end'] = request('end') ? request('end') : request('start');
        $purchases = collect([]);
        $impuestos = [];
        $subtotal = 0;
        $totalReporte = 0;
        $amountCaja = 0;
        $TotalEfectivo = 0;
        $TotalTarjeta = 0;
        $TotalCheque = 0;
        $TotalDeposito = 0;

        if(request('start')){

            $purchases = Purchase::search($search)->with('lines.taxes');

            //Se obtienen los impuestos aplicados en las lineas de las facturas
            $taxes = Purchase::select('purchases.id', 'purchase_line_taxes.tarifa','purchase_line_taxes.amount')
            ->join('purchase_lines', 'purchases.id', '=', 'purchase_lines.purchase_id')
            ->join('purchase_line_taxes', 'purchase_lines.id', '=', 'purchase_line_taxes.purchase_line_id')
            ->get();

            if( !$search['type'] ){
                $purchases = $purchases->where(function ($query) {
                    $query->where('TipoDocumento', '01')
                        ->orWhere('TipoDocumento', '04');
                });
            }
            $purchases = $purchases->where('status', 0)->get();

            $TotalEfectivo = $purchases->sum(function ($purchase) {
                return ($purchase->MedioPago == '01' && $purchase->CodigoMoneda == 'CRC') ? $purchase->TotalWithNota : 0;
            });
          
            $TotalTarjeta = $purchases->sum(function ($purchase) {
                return ($purchase->MedioPago == '02' && $purchase->CodigoMoneda == 'CRC') ? $purchase->TotalWithNota : 0;
            });
           
            $TotalCheque = $purchases->sum(function ($purchase) {
                return ($purchase->MedioPago == '03' && $purchase->CodigoMoneda == 'CRC') ? $purchase->TotalWithNota : 0;
            });
           
            $TotalDeposito = $purchases->sum(function ($purchase) {
                return ($purchase->MedioPago == '04' && $purchase->CodigoMoneda == 'CRC') ? $purchase->TotalWithNota : 0;
            });

            $impuestos = $this->getTaxes($purchases,$taxes);
            $purchases = $this->prepareData($purchases);
        }
    
        $totalReporte = $purchases->sum('TotalComprobante');
        $totalIVADevuelto = $purchases->sum('TotalIVADevuelto');
        $totalTaxes= $this->totalTaxes($purchases);


        if(request('print')){
            return view('reports.facturasProveedor.print', compact('purchases', 'totalReporte', 'TotalEfectivo', 
            'TotalTarjeta', 'TotalCheque', 'TotalDeposito', 'search','totalIVADevuelto','impuestos','totalTaxes'));
        }

        return view('reports.facturasProveedor.index', compact('purchases', 'totalReporte','search',
         'TotalEfectivo', 'TotalTarjeta', 'TotalCheque', 'TotalDeposito','totalIVADevuelto','impuestos','totalTaxes'));
    }

    //Se va a crear un array con el id de la factura y un string con los impuestos que lleva esa factura
    public function getTaxes($invoices,$taxes){
        $impuesto = [];

        foreach($invoices as $invoice){
            foreach($taxes as $tax){
                if($invoice->id == $tax->id){
                   $impuesto = $this->checkImpuesto($impuesto,$tax);
                }else{
                    if(!is_numeric(array_search($invoice->id, array_column($impuesto, 'factura')))){
                        array_push($impuesto,array('factura'=>$invoice->id,'Iva1'=>0,'Iva2'=>0,'Iva4'=>0,'Iva13'=>0,'totalIva'=>0));
                    }
                }
            }
        }
        return $impuesto;
    }
    
    //Se valida el impuesto para ir creando el string de impuestos
    public function checkImpuesto($impuesto,$tax){
        $tarifa = (string) intVal($tax->tarifa);
        $tarifa = $tarifa;
        $amount = (float) $tax->amount;

        if(Empty($impuesto)){
            if($tarifa == '13'){
                array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>0,'Iva2'=>0,'Iva4'=>0,'Iva13'=>$amount,'totalIva'=>$amount));
            }
            if($tarifa == '4'){
                array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>0,'Iva2'=>0,'Iva4'=>$amount,'Iva13'=>0,'totalIva'=>$amount));
            }
            if($tarifa == '2'){
                array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>0,'Iva2'=>$amount,'Iva4'=>0,'Iva13'=>0,'totalIva'=>$amount));
            }
            if($tarifa == '1'){
                array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>$amount,'Iva2'=>0,'Iva4'=>0,'Iva13'=>0,'totalIva'=>$amount));
            }
        }else{
            foreach($impuesto as $x=>$y){
                if(is_numeric(array_search($tax->id, array_column($impuesto, 'factura')))){
                    if($impuesto[$x]['factura']==$tax->id){
                        if($tarifa == '13'){
                            $impuesto[$x]['Iva13']=$impuesto[$x]['Iva13']+$amount;
                            $impuesto[$x]['totalIva']+=$amount;
                        }
                        if($tarifa == '4'){
                            $impuesto[$x]['Iva4']=$impuesto[$x]['Iva4']+$amount;
                            $impuesto[$x]['totalIva']+=$amount;
                        }
                        if($tarifa == '2'){
                            $impuesto[$x]['Iva2']=$impuesto[$x]['Iva2']+$amount;
                            $impuesto[$x]['totalIva']+=$amount;
                        }
                        if($tarifa == '1'){
                            $impuesto[$x]['Iva1']=$impuesto[$x]['Iva1']+$amount;
                            $impuesto[$x]['totalIva']+=$amount;
                        }
                        
                    }
                }else{
                    if($tarifa == '13'){
                        array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>0,'Iva2'=>0,'Iva4'=>0,'Iva13'=>$amount,'totalIva'=>$amount));
                    }
                    if($tarifa == '4'){
                        array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>0,'Iva2'=>0,'Iva4'=>$amount,'Iva13'=>0,'totalIva'=>$amount));
                    }
                    if($tarifa == '2'){
                        array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>0,'Iva2'=>$amount,'Iva4'=>0,'Iva13'=>0,'totalIva'=>$amount));
                    }
                    if($tarifa == '1'){
                        array_push($impuesto,array('factura'=>$tax->id,'Iva1'=>$amount,'Iva2'=>0,'Iva4'=>0,'Iva13'=>0,'totalIva'=>$amount));
                    }
                }
            }
        }

        return $impuesto;
    }

    public function totalTaxes($invoices){
        $totalTaxes = 0;
        foreach($invoices as $invoice){
            foreach($invoice->lines as $line){
                $totalTaxes+=$line->totalTaxes;
            }
        }
        return $totalTaxes;
    }

    public function prepareData($purchases){
        foreach($purchases as $purchase){
            switch ($purchase->MedioPago) {
                case '01':
                    $purchase->MedioPago = 'Efectivo';
                    break;
                case '02':
                    $purchase->MedioPago = 'Tarjeta';
                    break;
                case '03':
                    $purchase->MedioPago = 'Cheque';
                    break;
                case '04':
                    $purchase->MedioPago = 'Transferencia – depósito bancario';
                    break;
                
            }
            switch ($purchase->CondicionVenta) {
                case '01':
                    $purchase->CondicionVenta = 'Contado';
                    break;
                case '02':
                    $purchase->CondicionVenta = 'Credito';
                    break;
                
            }
        }
        
        return $purchases;
    }
}
