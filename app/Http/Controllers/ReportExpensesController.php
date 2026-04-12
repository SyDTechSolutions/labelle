<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Expense;
use App\Exports\ExpensesReportViewExport;
use Illuminate\Support\Carbon;

class ReportExpensesController extends Controller
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
        $search['MedioPago'] = request('MedioPago');
        $search['impuesto'] = request('impuesto');
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');

       
        $expenses = Expense::search($search)->get();
        $purchases = Purchase::search($search)->with('lines.taxes')->get();
        $taxes = Purchase::select('purchases.id', 'purchase_line_taxes.tarifa')
        ->join('purchase_lines', 'purchases.id', '=', 'purchase_lines.purchase_id')
        ->join('purchase_line_taxes', 'purchase_lines.id', '=', 'purchase_line_taxes.purchase_line_id')
        ->get();
        $gastos = $this->llenarGastos($expenses);

        $expensesTotals = clone $expenses;

        $total = $this->totalGastos($gastos);
        $totalTaxes = $this->totalTaxes($gastos);

        if(request('export')){
            return \Excel::download(new ExpensesReportViewExport($gastos), 'expenses.xlsx');
        }
        
        if(request('print')){
            return view('reports.expenses.print', compact('gastos', 'search','total','totalTaxes'));
        }      
        return view('reports.expenses.index', compact('gastos', 'search', 'total','totalTaxes'));
    }
    /**
     * Transforma los gastos en un formato estructurado con IVA segregado por tarifa.
     *
     * @param \Illuminate\Support\Collection $expenses
     * @return array
     */
    public function llenarGastos($expenses)
    {
        // Mapeo de códigos de medio de pago
        $mediosPago = [
            '01' => 'Efectivo',
            '02' => 'Tarjeta',
            '03' => 'Cheque',
            '04' => 'Transferencia – depósito bancario',
        ];

        return $expenses->map(function ($expense) use ($mediosPago) {
            // Calcular el porcentaje de impuesto
            $tipoImpuesto = ($expense->tipoImpuesto * 100) - 100;
            
            // Obtener método de pago legible
            $metodoPago = $mediosPago[$expense->MedioPago] ?? $expense->MedioPago;
            
            // Estructura base del gasto
            $gasto = [
                'fecha' => $expense->date,
                'referencia' => $expense->referencia,
                'metodoPago' => $metodoPago,
                'Iva1' => 0,
                'Iva2' => 0,
                'Iva4' => 0,
                'Iva13' => 0,
                'totalIva' => $expense->impuesto,
                'total' => $expense->amount,
            ];
            
            // Asignar el impuesto al tipo correspondiente
            switch ($tipoImpuesto) {
                case 1:
                    $gasto['Iva1'] = $expense->impuesto;
                    break;
                case 2:
                    $gasto['Iva2'] = $expense->impuesto;
                    break;
                case 4:
                    $gasto['Iva4'] = $expense->impuesto;
                    break;
                case 13:
                    $gasto['Iva13'] = $expense->impuesto;
                    break;
            }
            
            return $gasto;
        })->toArray();
    }

    /**
     * Calcula el total de gastos.
     *
     * @param array $gastos
     * @return float
     */
    public function totalGastos($gastos)
    {
        return array_sum(array_column($gastos, 'total'));
    }

    /**
     * Calcula el total de impuestos.
     *
     * @param array $gastos
     * @return float
     */
    public function totalTaxes($gastos)
    {
        return array_sum(array_column($gastos, 'totalIva'));
    }
}
