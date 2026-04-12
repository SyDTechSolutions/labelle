<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proforma;
use App\Mail\SendProforma;
use Illuminate\Support\Arr;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ProformaController extends Controller
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
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
        $search['created_by'] = request('created_by');



        $proformas = Proforma::search($search)->latest()->paginate(10);


        return view('proformas.index', compact('proformas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proformas.create', [
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
            'cliente' => 'required'

        ]);

        $data = $this->prepareData(request()->all());

        $proforma = Proforma::create($data);

        $proforma = $proforma->saveLines($data['lines']);

      
        return $proforma;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Proforma $proforma)
    {
        //$proforma->load('lines.taxes');
        $proforma->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        if (request()->wantsJson()) {
            return response($proforma, 200);
        }


        return view('proformas.edit', [
            'proforma' => $proforma,
            'tipoDocumento' => $proforma->TipoDocumento

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proforma $proforma)
    {
        $this->authorize('update', $proforma);

        $this->validate(request(), [
            'cliente' => 'required'

        ]);

        $proforma->fill(request()->all());
        $proforma->lines->each->delete();
        $proforma->update([
            'status' => 0
        ]);
        $proforma->save();

        
        $proforma = $proforma->saveLines(request('lines'));


        return $proforma;
    }

    public function updateSeller(Proforma $proforma)
    {
        
            $proforma->update([
                'created_by' => request('created_by'),
                
            ]);

            return $proforma;

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print(Proforma $proforma)
    {
        //$proforma->load('lines.taxes');
        $proforma->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        return view('proformas.print', compact('proforma'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ticket(Proforma $proforma)
    {
        //$proforma->load('lines.taxes');
        $proforma->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        return view('proformas.ticket', compact('proforma'));
     
    }


    public function pdf(Proforma $proforma)
    {
        $this->validate(request(), [
            'to' => 'required|email_array'
        ]);

        $emails = array_map('trim', array_filter(explode(',', request('to'))));

        //$proforma->load('lines.taxes','creator');
        $proforma->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'creator']);
       
        $pdf = \PDF::loadView('proformas.pdf', $proforma->toArray());


        try {
            \Mail::to($emails)->send(new SendProforma($pdf->output(), $proforma));

            if (request()->wantsJson()) {
                return response([], 200);
            }

        } catch (\Swift_TransportException $e) {  //Swift_RfcComplianceException
            if (request()->wantsJson()) {
                return response(['error'], 500);
            }
        }
        
        
    }

    public function destroy(Proforma $proforma)
    {
        $this->authorize('update', $proforma);

        $proforma->lines->each->delete();
        $proforma->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/proformas');
    }




    private function prepareData($data, $obligadoTributario = null)
    {

        $data['consecutivo'] = $this->crearConsecutivo($data['TipoDocumento']);

    
        if ($data['TipoDocumento'] != '01') {
            $data = Arr::except($data, array('id'));
        }

        $data['created_by'] = isset($data['created_by']) ? $data['created_by'] : auth()->id();


        return $data;
    }

    public function crearConsecutivo($tipoDocumento)
    {
      

        $consecutivo_inicio = 1;


        $consecutivo = Proforma::where('TipoDocumento', $tipoDocumento)->max('consecutivo');


        return ($consecutivo) ? $consecutivo += 1 : $consecutivo_inicio;
    }

   
}
