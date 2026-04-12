<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\PurchasePayment;

class PaymentPurchaseController extends Controller
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
    public function index(Purchase $purchase)
    {
        $search['q'] = request('q');

        $payments = $purchase->payments()->latest()->paginate(10);

        
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
    public function store(Request $request, Purchase $purchase)
    {
        $this->validate(request(), [
            'amount' => 'required|numeric',
    
        ]);

        $payment = $purchase->payments()->create(request()->all());

        return $payment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchasePayment $payment)
    {
        //$this->authorize('update', $payment);

        $payment->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/purchasepayments');
    }

    
}
