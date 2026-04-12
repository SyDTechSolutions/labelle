<?php

namespace App\Exports;

use App\Invoice;
use App\InvoiceLine;
use App\Product;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReceptorViewExport implements FromView
{   
    protected $receptor;

    function __construct($receptor) {
            $this->receptor = $receptor;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $receptors = $this->receptor;

        return view('reports.receptors.export', compact('receptors'));
        
    }
}
