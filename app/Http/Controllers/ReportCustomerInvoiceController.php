<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportCustomerInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       
    }
    
    public function index()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
        $search['order'] = request('order') ?: 'invoices_count';
        $search['dir'] = request('dir') ?: 'DESC';

        if(request('order') && !request('print') && !request('page')){
            if($search['order'] == 'invoices_count' &&  $search['dir'] == 'DESC'){
                $search['dir'] = 'ASC';
            }elseif($search['order'] == 'invoices_total' &&  $search['dir'] == 'DESC'){
                $search['dir'] = 'ASC';
            }else{
                $search['dir'] = 'DESC';
            }
        }

        $customers = null;

        if(request('start')){

                $start = new Carbon($search['start']);
                $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
                $end = new Carbon($end);

                $latestInvoices = \DB::table('invoices')
                   ->select('invoices.customer_id', \DB::raw('SUM(invoices.TotalWithNota) as invoices_total'), \DB::raw('COUNT(invoices.id) as invoices_count'))
                   ->whereBetween('invoices.created_at', [$start, $end->endOfDay()])
                    ->where(function ($query) {
                        $query->where('invoices.TipoDocumento', '01')
                            ->orWhere('invoices.TipoDocumento', '04');
                    })
                    ->groupBy('customer_id');
    

                $customers = \DB::table('customers')
                    ->leftJoinSub($latestInvoices, 'latest_invoices', function ($join) {
                        $join->on('customers.id', '=', 'latest_invoices.customer_id');
                    })
                    ->selectRaw('name, IFNULL(invoices_count, 0) as invoices_count, IFNULL(invoices_total, 0) as invoices_total')
                    ->orderBy($search['order'], $search['dir'])
                    ->orderBy('name');
               
              

            if(request('print')){
                $customers = $customers->get();
                return view('reports.customers.invoices_print', compact('customers'));
            }

            $customers = $customers->paginate(20);
        }

        return view('reports.customers.invoices', compact('customers','search'));
    }
}
