<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;

class CxPController extends Controller
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
        $purchases = Purchase::with('payments')
                //->where('CondicionVenta', '02')
                ->where('cxp_pending_amount', '>', 1)
                ->search($search)
                ->get();
      
        return view('cxp.index', compact('purchases', 'search'));
    }
    public function indexInfo(Purchase $purchase)
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
       
        $purchases = Purchase::with('payments')
                ->where('CondicionVenta', '02')
                ->where('cxp_pending_amount', '>', 1)
                ->where('provider_id', '=', $purchase->provider_id)
                ->search($search);

        $totalCompras = $purchases->sum('TotalComprobante');
        $totalPendiente = $purchases->sum('cxp_pending_amount');

        $purchases = $purchases->latest()->paginate(20);
      
        return view('cxp.FacInfo', compact('purchases', 'search', 'totalCompras', 'totalPendiente'));
    }
    public function indexContado()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');

       
        $purchases = Purchase::with('payments')
                //->where('CondicionVenta', '02')
                ->where('cxp_pending_amount', '>', 1)
                ->search($search);

        $totalCompras = $purchases->sum('TotalComprobante');
        $totalPendiente = $purchases->sum('cxp_pending_amount');

        $purchases = $purchases->latest()->paginate(20);
      
        return view('cxp.indexContado', compact('purchases', 'search', 'totalCompras', 'totalPendiente'));
    }

    public function print(Purchase $purchase)
    {
        $purchase->load('lines.taxes');
        $totalAbonos = 0;
        $pendiente = 0;

        $totalAbonos = $purchase->payments->sum('amount');
        $pendiente = $purchase->TotalComprobante - $totalAbonos;

        return view('cxp.print', compact('purchase', 'totalAbonos', 'pendiente'));
    }
}
