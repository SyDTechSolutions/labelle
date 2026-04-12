<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;

class ExpenseController extends Controller
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
        $search['MedioPago'] = request('MedioPago');



        $expenses = Expense::search($search)->latest()->paginate(10);


        return view('expenses.index', compact('expenses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'amount' => 'required|numeric',

        ]);

        $expense = Expense::create(request()->all());

        return $expense;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        

        if (request()->wantsJson()) {
            return response($expense, 200);
        }


        return view('expenses.edit', [
            'expense' => $expense,
          

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //$this->authorize('update', $expense);

         //dd(request()->all());

        $this->validate(request(), [
            'amount' => 'required',

        ]);

        $data = request()->all();

        $expense->fill($data);
        $expense->save();

        if (request()->wantsJson()) {
            return response($expense, 200);
        }

        flash('Gasto actualizado', 'success');

        return Redirect('/expense');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //$this->authorize('update', $payment);

        $expense->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/expenses');
    }

    public function lastFromCierre()
    {
        $search['date'] = request('date');
        $search['fromCierre'] = request('fromCierre');

        $expense = Expense::search($search)->latest()->first();

        if (request()->wantsJson()) {
            return response($expense, 200);
        }

        return Redirect('/expenses');
    }

    
}
