<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;

class CxCController extends Controller
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

       
        $invoices = Invoice::with('payments')
                    ->where(function ($query) {
                        $query->where('TipoDocumento', '01')
                            ->orWhere('TipoDocumento', '04');
                    })
                    ->where('CondicionVenta', '02')
                    ->where('TotalWithNota', '>', 1)
                    ->where('cxc_pending_amount', '>', 1)
                    ->search($search)->latest()->paginate(10);

        //temporarl para actualizar todas las cxc
        // foreach($invoices as $invoice){
        //     $invoice->calculatePendingAmount();
        // }
        return view('cxc.index', compact('invoices', 'search'));
    }
    //Metodo que devuelve las cuentas que ya estan pagadas, es lo mismo que index pero se cambio la consulta sql 
    public function pagadas()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');

       
        $invoices = Invoice::with('payments')
                    ->where(function ($query) {
                        $query->where('TipoDocumento', '01')
                            ->orWhere('TipoDocumento', '04');
                    })
                    ->where('CondicionVenta', '02')
                    ->where('TotalWithNota', '>', 1)
                    ->where('cxc_pending_amount', '<', 1)
                    ->search($search)->latest()->paginate(10);

        //temporarl para actualizar todas las cxc
        // foreach($invoices as $invoice){
        //     $invoice->calculatePendingAmount();
        // }

        return view('cxc.cxcPagadas', compact('invoices', 'search'));
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('lines.taxes', 'referencias');
        $totalAbonos = 0;
        $pendiente = 0;

        $totalAbonos = $invoice->payments->sum('amount');
        $pendiente = $invoice->TotalComprobante - $totalAbonos;

        return view('cxc.print', compact('invoice', 'totalAbonos', 'pendiente'));
    }
}
