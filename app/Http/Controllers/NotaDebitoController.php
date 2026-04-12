<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use App\Invoice;

class NotaDebitoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        $currency = Currency::where("name","dollar")->first();
        
        return view('invoices.create', [
            'invoice' => $invoice->load('lines.taxes', 'referencias'),
            'tipoDocumento' => '02',
            'creatingNota' => 1,
            'caja'=>'1',
            'currency'=>$currency->exchange
        ]);
    }

   
}
