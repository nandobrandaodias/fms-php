<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return response()->json($payments, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bill_id' => 'required',
            'value' => 'required',
            'payment_method' => 'required',
            'payment_date' => 'required'
        ]);

        $payment = new Payment;

        $payment::create([
            'bill_id' => $request->bill_id,
            'value' => $request->value,
            'created_at' => date("Y/m/d"), 
            'payment_method' => $request->payment_method, 
            'payment_date' => $request->payment_date,
        ]);

        return response('',200);
    }

    public function show(Request $request, Payment $payment)
    {
        $payment = Payment::find($payment);
        return response()->json($payment, 200);
    }


    public function update(Request $request, Payment $payment)
    {
        $payment->update([
            'bill_id' => $request->bill_id,
            'value' => $request->value,
            'payment_method' => $request->payment_method, 
            'payment_date' => $request->payment_date,
        ]);

        return response('',200);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response('',200);
    }
}
