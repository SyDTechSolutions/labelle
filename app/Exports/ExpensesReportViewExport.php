<?php

namespace App\Exports;

use App\Invoice;
use App\InvoiceLine;
use App\Product;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExpensesReportViewExport implements FromView
{   
    protected $gastos;

    function __construct($gastos) {
            $this->gastos = $gastos;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $gastos = $this->gastos;
        $total = $this->totalGastos($gastos);
        $totalTaxes = $this->totalTaxes($gastos);

        return view('reports.expenses.export', compact('gastos', 'total','totalTaxes'));
        
    }
    public function totalGastos($gastos){
        $total = 0;
        foreach($gastos as $x=>$i){
            $total += $gastos[$x]['total'];
        }
        return $total;
    }
    public function totalTaxes($gastos){
        $total = 0;
        foreach($gastos as $x=>$i){
            $total += $gastos[$x]['totalIva'];
        }
        return $total;
    }
}
