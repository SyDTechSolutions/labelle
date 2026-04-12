<?php

namespace App\Exports;

use App\Invoice;
use App\InvoiceLine;
use App\Product;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceReportViewExport implements FromView
{   
    protected $invoices;
    protected $totals;

    function __construct($invoices,$totals) {
            $this->invoices = $invoices;
            $this->totals = $totals;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $invoices = $this->invoices;
        $totalVentas = $this->totals->subtotal;
        $totalReporte = $this->totals->total;
        $totalTaxes = $this->totals->impuestos;
        $amountCaja = 0;
        $totalIVADevuelto = 0;
        $TotalEfectivo = $this->totals->efectivo;
        $TotalTarjeta = $this->totals->tarjeta;
        $TotalCheque = $this->totals->cheque;
        $TotalDeposito = $this->totals->transferencia;
    
        return view('reports.invoices.export', compact('totalVentas','totalReporte','amountCaja','TotalEfectivo', 'TotalTarjeta', 'TotalCheque', 'TotalDeposito','totalIVADevuelto','invoices','totalTaxes'));
    }
    
}
