<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search['q'] = request('q');

        if (request('q')) {
            $currencies = Currency::search(request('q'))->latest()->paginate(10);
        } else {
            $currencies = Currency::latest()->paginate(10);
        }

        return view('currencies.index', compact('currencies', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currencies.create');
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
            'code' => 'required',
            'name' => 'required|string|max:255'
        ]);

        $currency = Currency::create(request()->all());

        flash('Moneda creado', 'success');

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/currencies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $this->authorize('update', $currency);

        $this->validate(request(), [
            'exchange' => 'required'
        ]);

        $currency->fill(request()->all());
        $currency->save();

        if (request()->wantsJson()) {
            return response("Moneda actualizada", 204);
        }

        flash('Moneda actualizada', 'success');

        

        return Redirect('/currencies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $this->authorize('update', $currency);

        $currency->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/currencies');
    }

}
