<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Payment;

class PaymentInvoiceController extends Controller
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
    public function index(Invoice $invoice)
    {
        $search['q'] = request('q');

        $payments = $invoice->payments()->latest()->paginate(10);

        if (request()->wantsJson()) {
            return response($payments, 200);
        }

       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Invoice $invoice)
    {
        $this->validate(request(), [
            'amount' => 'required|numeric',
    
        ]);

        $payment = $invoice->payments()->create(request()->all());

        return $payment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //$this->authorize('update', $payment);

        $payment->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/payments');
    }

    
}
