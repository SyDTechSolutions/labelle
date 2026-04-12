<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use App\Payment;
use Illuminate\Http\Request;

class CustomerCxCController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Customer $customer)
    {
        $data = $this->generateReport($customer);

        $customer->TotalCxc = $data->sum('amount');

        $items = paginate($data->sortBy('date')->values()->all(), 10);

        return response()->json([
            'data' => $items,
            'customer' => $customer
        ]);
    }

    public function print(Customer $customer)
    {
        $data = $this->generateReport($customer);

        $customer->TotalCxc = $data->sum('amount');

        $items = $data->sortBy('date')->values();

        $items = $this->getCredito($items);

        return view('customers.cxc.print', ['data' => $items, 'customer' => $customer]);
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
    //Ayuda a obtener el credito, haciendo un nuevo array y agregando los campos que se van a necesitar, después se reemplaza por el que se va mandar al view
    public function getCredito(Object $items){
        $factura = [];
        foreach($items as $key => $valor) {
            if($valor->type=='D'){
                array_push($factura,array("date"=>$valor->date,"dateVen"=>$valor->dateVen,"descrition"=>$valor->description,"debito"=>$valor->amount,
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
    public function generateReport(Customer $customer)
    {
        $credito = 0;
        $invoices = Invoice::where('CondicionVenta', '02')
            ->where('customer_id', $customer->id)
            ->where(function ($query) {
                $query->where('TipoDocumento', '01')
                    ->orWhere('TipoDocumento', '04');
            })
            ->where('TotalWithNota', '>', 1)
            ->select('id', 'created_at', 'consecutivo', 'TotalWithNota', 'PlazoCredito')
            ->get();
        
        $invoiceIds = $invoices->pluck('id');
        $payments = Payment::with('invoice:id,consecutivo')
            ->whereIn('invoice_id', $invoiceIds)
            ->get();

        $items = $invoices->map(function ($item, $key) {
           return (object)[
                'date' => $item->created_at->toDateTimeString(),
                'dateVen' => $item->PlazoCredito,
                'type' => 'D',
                'description' => 'Fac. #' . $item->consecutivo,
                'amount' => (float) $item->TotalWithNota,
                'factura'=>$item->consecutivo,
            ];
        });

        $data = $items->concat($payments->map(function ($item, $key) {
            return (object)[
                'date' => $item->created_at->toDateTimeString(),
                'type' => 'C',
                'description' => 'Abono a Fac #' . $item->invoice->consecutivo,
                'amount' => -(float) $item->amount,
                'factura'=>$item->invoice->consecutivo,
            ];
        }));

        return $data;
    }
}
