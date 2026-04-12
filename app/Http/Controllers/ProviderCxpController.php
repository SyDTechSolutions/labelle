<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Purchase;
use App\PurchasePayment;
use Illuminate\Http\Request;

class ProviderCxpController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Purchase $purchase)
    {
        $data = $this->generateReport($purchase);

        $items = paginate($data->sortBy('date')->values()->all(), 10);

        return response()->json([
            'data' => $items
        ]);
    }
    

    public function print(Purchase $purchase)
    {
        $data = $this->generateReport($purchase);

        $purchase->load('lines.taxes');
        $totalAbonos = 0;
        $pendiente = 0;
        $items = $data->sortBy('date')->values();

        $items = $this->getCredito($items);
        $totalAbonos = $this->getAbonos($items);
        $pendiente = $this->getPendiente($items)-$totalAbonos; 
        $montoCuenta = $this->getPendiente($items);

        return view('cxp.printEstado', ['data' => $items],compact('purchase', 'totalAbonos', 'pendiente','montoCuenta'));
    }
    //No esta funcionando muy bien 
    public function printPagadas(Customer $customer)
    {
        $data = $this->generateReport($customer);

        $customer->TotalCxc = $data->sum('amount');

        $items = $data->sortBy('date')->values();

        $items = $this->getCredito($items);

        return view('customers.cxc.printHistorial', ['data' => $items, 'customer' => $customer]);
    }
    public function getAbonos(Array $items){
        $totalAbonos = 0.0;
        foreach($items as $x=>$y){
            foreach($items[$x]['abonos'] as $abono){
                $totalAbonos += $abono['abono'];
            }
        }
        return $totalAbonos;
    }

    public function getPendiente(Array $items){

        $totalPendiente = 0.0;
        foreach($items as $x=>$y){
            $totalPendiente += $items[$x]['debito'];
        }
        return $totalPendiente;
    }
    //Ayuda a obtener el credito, haciendo un nuevo array y agregando los campos que se van a necesitar, después se reemplaza por el que se va mandar al view
    public function getCredito(Object $items){
        $factura = [];
        foreach($items as $key => $valor) {
            if($valor->type=='D'){
                array_push($factura,array("date"=>$valor->date,"dateVen"=>$valor->dateVen,"nombre"=>$valor->nombre,"debito"=>$valor->amount,
                                "factura"=>$valor->factura,"credito"=>0,"saldo"=>0,"dVencidos"=>'2020-01-10',"abonos"=>[]));
            }else{
                foreach($factura as $x=>$y){
                    if($y['factura']==$valor->factura){
                        $factura[$x]['credito']+=abs($valor->amount);
                        $factura[$x]['saldo']=$factura[$x]['debito']-$factura[$x]['credito'];
                        array_push($factura[$x]['abonos'],array('abono'=>abs($valor->amount),'fAbono'=>$valor->date));
                    }
                }
            } 
        }

        foreach($factura as $x=>$y){
            $factura[$x]['dVencidos'] = $this->getDiasVencidos($factura[$x]['dateVen']);
        }
        
        return $factura;
    }
    //Ayuda a obtener los dias vencidos
    public function getDiasVencidos($fecha){
        $fecha_actual= date("Y-m-d");
        if($fecha_actual>$fecha){
            $dias = (strtotime($fecha_actual)-strtotime($fecha))/86400;
            $dias = abs($dias); 
            return $dias;
        }else{
            return 0;
        }
      
    }
    public function generateReport(Purchase $purchase)
    {

        $credito = 0;
        $purchases = Purchase::where('CondicionVenta', '02')
            ->where('provider_id', $purchase->id)
            ->where(function ($query) {
                $query->where('TipoDocumento', '01')
                    ->orWhere('TipoDocumento', '04');
            })
            ->where('cxp_pending_amount', '>', 1)
            ->select('id', 'created_at', 'cliente', 'TotalComprobante', 'PlazoCredito','consecutivo')
            ->get();
        
        $purchaseIds = $purchases->pluck('id');

        $payments = PurchasePayment::with('purchase:id')
            ->whereIn('purchase_id', $purchaseIds)
            ->get();

        $items = $purchases->map(function ($item, $key) {
           return (object)[
                'date' => $item->created_at->toDateTimeString(),
                'dateVen' => $item->PlazoCredito,
                'type' => 'D',
                'nombre' => $item->cliente,
                'amount' => (float) $item->TotalComprobante,
                'factura'=>$item->consecutivo,
            ];
        });

        $data = $items->concat($payments->map(function ($item, $key) {
            return (object)[
                'date' => $item->created_at->toDateTimeString(),
                'type' => 'C',
                'description' => 'Abono a Fac #' . $item->purchase->id,
                'amount' => -(float) $item->amount,
                'factura'=>$item->purchase->id,
            ];
        }));
        
        return $data;
    }
}
