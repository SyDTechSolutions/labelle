<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use Illuminate\Support\Carbon;

class ReportCxPController extends Controller
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

       
        $purchases = Purchase::where('PlazoCredito', '<', Carbon::now()->toDateString())
                ->where('cxp_pending_amount', '>', 1)
                ->search($search)->latest();

    
        $purchasesTotals = clone $purchases;
        $total = $purchasesTotals->sum('TotalComprobante');
        $totalPending = $purchasesTotals->sum('cxp_pending_amount');
        

      

        if(request('print')){
            $purchases = $purchases->get();

            return view('reports.cxps.print', compact('purchases', 'search','total', 'totalPending'));
        }

        $purchases = $purchases->paginate(20);
      
        return view('reports.cxps.index', compact('purchases', 'search','total', 'totalPending'));
    }

   
}
