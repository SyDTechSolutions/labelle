<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Caja;
use App\Exports\InvoiceReportViewExport;
use Illuminate\Support\Facades\DB;

class ReportInvoiceController extends Controller
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

        $search['type'] = request('type');

        $search['condicion'] = request('condicion');

        $search['MedioPago'] = request('MedioPago');

        $search['start'] = request('start');

        $search['end'] = request('end') ? request('end') : request('start');

        $search['created_by'] = request('created_by');

        $search['adviser'] = request('adviser');


        $invoices = collect([]);

        $info = [];

        $impuestos = [];

        $subtotal = 0;

        $totalReporte = 0;

        $amountCaja = 0;

        $TotalEfectivo = 0;

        $TotalTarjeta = 0;

        $TotalCheque = 0;

        $TotalDeposito = 0;

        $TotalAbonos = 0;

        $totalVentas = 0;

        $totalReporte = 0;
    
        $totalIVADevuelto = 0;

        $totalTaxes= 0;

        $totalPending= 0;

        if(request('start')){

            //Se obtienen los impuestos aplicados en las lineas de las facturas

            $invoices = Invoice::select(
                'invoices.id',
                'invoices.consecutivo',
                'invoices.CodigoActividadEmisor',
                'invoices.CodigoActividadReceptor',
                'invoices.CodigoMoneda',
                'invoices.TipoDocumento',
                'invoices.CondicionVenta',
                'invoices.created_at',
                'invoices.identificacion_cliente',
                'invoices.cliente',
                'invoices.MedioPago',
                'invoices.TotalVentaNeta',
                'invoices.TotalImpuesto',
                'invoices.TotalComprobante',
                'invoices.TotalWithNota',
                \DB::raw('SUM(CASE WHEN invoice_line_taxes.tarifa = 13 THEN invoice_lines.totalTaxes ELSE 0 END) AS trece'),
                \DB::raw('SUM(CASE WHEN invoice_line_taxes.tarifa = 7 THEN invoice_lines.totalTaxes ELSE 0 END) AS siete'),
                \DB::raw('SUM(CASE WHEN invoice_line_taxes.tarifa = 4 THEN invoice_lines.totalTaxes ELSE 0 END) AS cuatro'),
                \DB::raw('SUM(CASE WHEN invoice_line_taxes.tarifa = 2 THEN invoice_lines.totalTaxes ELSE 0 END) AS dos'),
                \DB::raw('SUM(CASE WHEN invoice_line_taxes.tarifa = 1 THEN invoice_lines.totalTaxes ELSE 0 END) AS uno'),
                'invoices.status',
                'invoices.canceled'
            )
             ->join('invoice_lines', 'invoices.id', '=', 'invoice_lines.invoice_id')
            ->join('invoice_line_taxes', 'invoice_lines.id', '=', 'invoice_line_taxes.invoice_line_id')
            ->search($search)
            ->where('invoices.status', 1)
            ->groupBy(
                'invoices.id',
                'invoices.consecutivo',
                'invoices.CodigoActividadEmisor',
                'invoices.CodigoActividadReceptor',
                'invoices.CodigoMoneda',
                'invoices.TipoDocumento',
                'invoices.CondicionVenta',
                'invoices.created_at',
                'invoices.identificacion_cliente',
                'invoices.cliente',
                'invoices.MedioPago',
                'invoices.TotalVentaNeta',
                'invoices.TotalImpuesto',
                'invoices.TotalComprobante',
                'invoices.TotalWithNota',
                'invoices.status',
                'invoices.canceled'
            )
            ->get()
            ->toArray();
            
            $invoices_temp = collect($invoices);
            $totals = new \stdClass;

            $totals->efectivo = $invoices_temp->where('MedioPago','01')
            ->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->sum("TotalWithNota");

            $totals->tarjeta = $invoices_temp->where('MedioPago','02')
            ->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->sum("TotalWithNota");

            $totals->cheque = $invoices_temp->where('MedioPago','03')
            ->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->sum("TotalWithNota");

            $totals->transferencia = $invoices_temp->where('MedioPago','04')
            ->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->sum("TotalWithNota");

            $totals->pendiente = $invoices_temp->where('CondicionVenta','02')
            ->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->sum("TotalWithNota");

            $totals->impuestos = $invoices_temp->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->sum("TotalImpuesto");

            $totals->subtotal = $invoices_temp->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->where('TotalWithNota','>','0')
            ->sum("TotalVentaNeta");

            $totals->total = $invoices_temp->where('TipoDocumento','!=','02')
            ->where('TipoDocumento','!=','03')
            ->sum("TotalWithNota");

            $TotalEfectivo = $totals->efectivo;
            $TotalTarjeta = $totals->tarjeta;
            $TotalCheque = $totals->cheque;
            $TotalDeposito = $totals->transferencia;
    
            $totalVentas = $totals->subtotal;
    
            $totalReporte = $totals->total;
    
            $totalIVADevuelto = 0;
    
            $totalTaxes= $totals->impuestos;
            $totalPending= $totals->pendiente;
        }


        $cajaIni = Caja::whereDate('created_at', request('end'))->first();

        if($cajaIni){

            $amountCaja = $cajaIni->amount;

            $totalReporte += $amountCaja;

        }



        if(request('export')){
            return \Excel::download(new InvoiceReportViewExport($invoices,$totals), 'invoices.xlsx');

        }

        if(request('print')){

            return view('reports.invoices.print', compact('totalVentas','totalReporte','search', 'amountCaja',

            'TotalEfectivo', 'TotalTarjeta', 'TotalCheque', 'TotalDeposito','totalIVADevuelto','invoices','totalTaxes','TotalAbonos','totalPending'));

        }



        return view('reports.invoices.index', compact('totalVentas','totalReporte','search', 'amountCaja',

         'TotalEfectivo', 'TotalTarjeta', 'TotalCheque', 'TotalDeposito','totalIVADevuelto','invoices','totalTaxes','TotalAbonos','totalPending'));

    }

    public function summary()
    {
        $search['start'] = request('start');
        $search['end'] = request('end') ? request('end') : request('start');

        $defaults = [
            'total_general_ventas' => "0.00",
            'total_efectivo' => "0.00",
            'total_tarjeta' => "0.00",
            'total_credito' => "0.00",
            'total_gravado' => "0.00",
            'total_exento' => "0.00",
            'total_impuestos' => "0.00",
            'total_nota_credito' => "0.00",
            'total_nota_debito' => "0.00",
            'tarifa' => "0.00",
            'total_impuesto_por_tarifa' => "0.00000",
            'costo_inventario' => 0.0,
            'ganancias' => 0.0
        ];

        $total_taxes = [];
        $report = (object) $defaults;

        if(request('start')){ 
            $results = DB::select('CALL summary_report(?, ?)', [$search['start'], $search['end']]);
            $total_taxes = DB::select("
                SELECT 
                    ilt.tarifa, 
                    ROUND(SUM(ilt.ImpuestoNeto),2) AS total
                FROM invoice_line_taxes AS ilt
                INNER JOIN invoice_lines AS il ON il.id = ilt.invoice_line_id
                WHERE il.created_at BETWEEN ? AND ?
                GROUP BY ilt.tarifa
            ", [$search['start'], $search['end']]);
            
            if (!empty($results)) {
                $report = (object) array_merge($defaults, (array) collect($results)->first());
            }
        }

        if(request('print')){

            return view('reports.invoices.summaryPrint', compact('report', 'search', 'total_taxes'));

        }

        return view('reports.invoices.summary', compact('report', 'search', 'total_taxes'));
    }
    
}
