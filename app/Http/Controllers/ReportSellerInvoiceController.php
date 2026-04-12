<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportSellerInvoiceController extends Controller
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
        $sellers = collect([]);

        if(request('start')){

                $start = new Carbon($search['start']);
                $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
                $end = new Carbon($end);
        
                $sellers = \DB::table('invoices')
                ->join('users', 'invoices.created_by', '=', 'users.id')
                ->select('users.id','users.name', \DB::raw('COUNT(invoices.id) as invoices_count'),\DB::raw('SUM(invoices.TotalWithNota) as invoices_total'), 'users.commission', \DB::raw('(users.commission / 100) * SUM(invoices.TotalWithNota) as commission_total') )
                ->whereBetween('invoices.created_at', [$start, $end->endOfDay()])
                ->where(function ($query) {
                    $query->where('TipoDocumento', '01')
                        ->orWhere('TipoDocumento', '04');
                })
                ->groupBy('users.id', 'users.name', 'users.commission');
                

    
                        
                $sellers = $sellers->orderBy('invoices_count', 'DESC');

               
        
            if(request('print')){
                $sellers = $sellers->get();
                return view('reports.sellers.invoices_print', compact('sellers'));
            }

            $sellers = $sellers->get();
        }

        return view('reports.sellers.invoices', compact('sellers','search'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchased()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
        $products = collect([]);

        if(request('start')){

            $start = new Carbon($search['start']);
            $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
            $end = new Carbon($end);
            

            
                $products = \DB::table('purchases')
                ->join('purchase_lines', 'purchases.id', '=', 'purchase_lines.purchase_id')
                ->join('products', 'purchase_lines.Codigo', '=', 'products.code')
                ->select('purchases.id', 'purchases.created_at', 'purchases.consecutivo','purchases.factura_proveedor','purchases.cliente','purchase_lines.Codigo','purchase_lines.Detalle', 'products.purchase_price')
                ->whereBetween('purchases.created_at', [$start, $end->endOfDay()]);
          
            
                if(request('q')){
                    $products->where('products.code', request('q'));
                }

            
       
    
       
        if(request('print')){
            $products = $products->get();
            return view('reports.products.purchased_print', compact('products'));
        }

        $products = $products->paginate(20);

        }

        return view('reports.products.purchased', compact('products','search'));
    }
}
