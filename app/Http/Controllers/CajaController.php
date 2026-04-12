<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use App\Proforma;

class CajaController extends Controller
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

    public function index()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
        $search['created_by'] = request('created_by');



        $proformas = Proforma::search($search)->latest()->paginate(10);


        return view('caja.index', compact('proformas', 'search'));
    }
    public function store(Request $request)
    {
        $this->validate(request(), [
            'amount' => 'required|numeric',
        ]);


        $caja = Caja::create(request()->all());

        return $caja;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caja $caja)
    {
        $this->validate(request(), [
            'amount' => 'required|numeric',
        ]);


        $caja->update([
            'amount' => request('amount')
        ]);

        return $caja;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Caja::whereDate('created_at', \Carbon\Carbon::now()->toDateString())->first();
    }

}
