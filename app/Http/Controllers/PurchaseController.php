<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Mail\SendPurchase;
use App\Product;
use App\ProformaPurchase;
use App\Rules\UniquePurchase;
use Illuminate\Support\Arr;

class PurchaseController extends Controller
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
        $this->authorize('create', Purchase::class);

        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');



        $purchases = Purchase::search($search);

        $totalCompras = $purchases->sum('TotalComprobante');

        $purchases = $purchases->latest()->paginate(20);


        return view('purchases.index', compact('purchases', 'search', 'totalCompras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Purchase::class);

        $proforma = null;
        if(request('p')){
            $proforma = ProformaPurchase::with('lines.taxes')->find(request('p'));
            
        }

        return view('purchases.create', [
            'tipoDocumento' => '01',
            'proforma' => $proforma
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'cliente' => 'required',
            'factura_proveedor' => ['nullable', new UniquePurchase(request('provider_id'))],

        ]);

        $data = $this->prepareData(request()->all());

        $purchase = Purchase::create($data);

        $purchase = $purchase->saveLines($data['lines']);

        if (isset($data['initialPayment']) && $data['initialPayment']) {
            $purchase->payments()->create([
                "amount" => $data['initialPayment']
            ]);
        }

      
        return $purchase;

    }

    public function check(Request $request)
    {
        $resp = Purchase::where('provider_id', request('provider'))->where('factura_proveedor', request('fac'))->exists();

        if($resp){
            $resp = 'exists';
        }else{
            $resp = 'no';
        }
        if (request()->wantsJson()) {
            return response($resp, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $this->authorize('update', $purchase);
        
        //$purchase->load('lines.taxes');
        $purchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);


        if (request()->wantsJson()) {
            return response($purchase, 200);
        }


        return view('purchases.edit', [
            'purchase' => $purchase,
            'tipoDocumento' => $purchase->TipoDocumento

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $this->authorize('update', $purchase);

        $this->validate(request(), [
            'cliente' => 'required',
            'factura_proveedor' => ['nullable', new UniquePurchase(request('provider_id'), $purchase->id)],

        ]);

        $purchase->fill(request()->all());
        $purchase->lines->each->delete();
        $purchase->save();

        
        $purchase = $purchase->saveLines(request('lines'));

        $purchase->calculatePendingAmount();


        return $purchase;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print(Purchase $purchase)
    {
        //$purchase->load('lines.taxes');
        $purchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        return view('purchases.print', compact('purchase'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ticket(Purchase $purchase)
    {
        //$purchase->load('lines.taxes');
        $purchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        return view('purchases.ticket', compact('purchase'));
       
    }
    


    public function pdf(Purchase $purchase)
    {
        $this->validate(request(), [
            'to' => 'required|email_array'
        ]);

        $emails = array_map('trim', array_filter(explode(',', request('to'))));

        //$purchase->load('lines.taxes', 'creator');
        $purchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'creator']);
       
        $pdf = \PDF::loadView('purchases.pdf', $purchase->toArray());


        try {
            \Mail::to($emails)->send(new SendPurchase($pdf->output(), $purchase));

            if (request()->wantsJson()) {
                return response([], 200);
            }

        } catch (\Swift_TransportException $e) {  //Swift_RfcComplianceException
            if (request()->wantsJson()) {
                return response(['error'], 500);
            }
        }
        
        
    }

    public function destroy(Purchase $purchase)
    {
        $this->authorize('update', $purchase);

        foreach($purchase->lines as $line){

             $product = Product::where('code', $line->Codigo)->first();

            if($product){
               
                $quantity = $product->quantity - $line->unidades;
                $product->update([
                    'quantity' => $quantity < 0 ? 0 : $quantity,
                ]);

            }
        }
       
        $purchase->lines->each->delete();
        $purchase->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/purchases');
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


        $consecutivo = Purchase::where('TipoDocumento', $tipoDocumento)->max('consecutivo');


        return ($consecutivo) ? $consecutivo += 1 : $consecutivo_inicio;
    }

   
}
