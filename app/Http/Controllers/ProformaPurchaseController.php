<?php

namespace App\Http\Controllers;

use App\Mail\SendProformaPurchase;
use Illuminate\Http\Request;
use App\ProformaPurchase;
use App\ProformaPurchaseLine;
use App\Rules\UniquePurchase;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ProformaPurchaseController extends Controller
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
        $this->authorize('create', ProformaPurchase::class);

        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');



        $proformapurchases = ProformaPurchase::search($search);

        $totalCompras = $proformapurchases->sum('TotalComprobante');

        $proformapurchases = $proformapurchases->latest()->paginate(20);


        return view('proformaPurchases.index', compact('proformapurchases', 'search', 'totalCompras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ProformaPurchase::class);

        return view('proformaPurchases.create', [
            'tipoDocumento' => '01'
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
            'factura_proveedor' => ['nullable'],

        ]);

        $data = $this->prepareData(request()->all());

        $proformapurchase = ProformaPurchase::create($data);

        $proformapurchase = $proformapurchase->saveLines($data['lines']);

        if (isset($data['initialPayment']) && $data['initialPayment']) {
            $proformapurchase->payments()->create([
                "amount" => $data['initialPayment']
            ]);
        }

      
        return $proformapurchase;

    }

    public function check(Request $request)
    {
        $resp = ProformaPurchase::where('provider_id', request('provider'))->where('factura_proveedor', request('fac'))->exists();

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
    public function show(ProformaPurchase $proformapurchase)
    {
        $this->authorize('update', $proformapurchase);
        
        //$proformapurchase->load('lines.taxes');
        $proformapurchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        if (request()->wantsJson()) {
            return response($proformapurchase, 200);
        }


        return view('proformaPurchases.edit', [
            'proformaPurchase' => $proformapurchase,
            'tipoDocumento' => $proformapurchase->TipoDocumento

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProformaPurchase $proformapurchase)
    {
        $this->authorize('update', $proformapurchase);

        $this->validate(request(), [
            'cliente' => 'required',
            'factura_proveedor' => ['nullable'],

        ]);

        $proformapurchase->fill(request()->all());
        $proformapurchase->lines->each->delete();

        if(!$proformapurchase->opening){
            $proformapurchase->opening = Carbon::now();
           
        }

        $proformapurchase->save();

        
        $proformapurchase = $proformapurchase->saveLines(request('lines'));

        //$proformapurchase->calculatePendingAmount();


        return $proformapurchase;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print(ProformaPurchase $proformapurchase)
    {
        //$proformapurchase->load('lines.taxes');
        $proformapurchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        return view('proformaPurchases.print', compact('proformapurchase'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ticket(ProformaPurchase $proformapurchase)
    {
        //$proformapurchase->load('lines.taxes');
        $proformapurchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        return view('proformaPurchases.ticket', compact('proformapurchase'));
       
    }
 

    public function pdf(ProformaPurchase $proformapurchase)
    {
        $this->validate(request(), [
            'to' => 'required|email_array'
        ]);

        $emails = array_map('trim', array_filter(explode(',', request('to'))));

        //$proformapurchase->load('lines.taxes', 'creator');
        $proformapurchase->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'creator']);
       
        $pdf = \PDF::loadView('proformaPurchases.pdf', $proformapurchase->toArray());


        try {
            \Mail::to($emails)->send(new SendProformaPurchase($pdf->output(), $proformapurchase));

            if (request()->wantsJson()) {
                return response([], 200);
            }

        } catch (\Swift_TransportException $e) {  //Swift_RfcComplianceException
            if (request()->wantsJson()) {
                return response(['error'], 500);
            }
        }
        
        
    }

    public function destroy(ProformaPurchase $proformapurchase)
    {
        $this->authorize('update', $proformapurchase);
        
        $proformapurchase->lines->each->delete();
        $proformapurchase->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/proformapurchases');
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
