<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportProductController extends Controller
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
        $products = collect([]);

        if(request('start')){

                $start = new Carbon($search['start']);
                $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
                $end = new Carbon($end);
        
                $products = \DB::table('invoices')
                ->join('invoice_lines', 'invoices.id', '=', 'invoice_lines.invoice_id')
                ->join('products', 'invoice_lines.Codigo', '=', 'products.code')
                ->distinct()
                ->select('invoice_lines.Codigo', 'invoice_lines.Detalle',\DB::raw('products.quantity as ExistenciaUnid'),\DB::raw('SUM(invoice_lines.Cantidad) as TotalUnidades') )
                ->whereBetween('invoices.created_at', [$start, $end->endOfDay()])
                //->havingRaw('SUM(invoice_lines.Cantidad) > ?', [100])
                ->groupBy('invoice_lines.Codigo','invoice_lines.Detalle','products.quantity');
                

                if($search['q']){
                    $products->where(function ($query) use ($search) {
                        $query->where('invoice_lines.Detalle', 'like', '%' . $search['q'] . '%')
                            ->orWhere('invoice_lines.Codigo', 'like', '%' . $search['q'] . '%');
                    });
                }
                
                        
                $products = $products->orderBy('TotalUnidades', 'DESC');
        
            if(request('print')){
                $products = $products->get();
                return view('reports.products.sold_print', compact('products'));
            }

            $products = $products->get();
        }

        return view('reports.products.sold', compact('products','search'));
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
