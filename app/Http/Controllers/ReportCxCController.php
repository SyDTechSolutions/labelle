<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use Illuminate\Support\Carbon;

class ReportCxCController extends Controller
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

       
        $invoices = Invoice::where('CondicionVenta', '02')
                ->where('PlazoCredito', '<', Carbon::now()->toDateString())
                ->where('cxc_pending_amount', '>', 1)
                ->search($search)->latest();

    
         $invoicesTotals = clone $invoices;
         $total = $invoicesTotals->sum('TotalComprobante');
         $totalPending = $invoicesTotals->sum('cxc_pending_amount');

        if(request('print')){
            $invoices = $invoices->get();

            return view('reports.cxcs.print', compact('invoices', 'search','total', 'totalPending'));
        }

        $invoices = $invoices->paginate(20);
      
        return view('reports.cxcs.index', compact('invoices', 'search', 'total', 'totalPending'));
    }

   
}
