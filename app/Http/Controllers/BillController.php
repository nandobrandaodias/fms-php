<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillCollection;
use App\Http\Resources\BillResource;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        // $bills = new BillCollection(Bill::all());
        $bills = Bill::all()->load(['payments']);
        return response()->json($bills, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cost' => 'required',
            'client_id' => 'required',
            'reference_month' => 'required',
            'expiration_date' => 'required',
        ]);

        $bill = new Bill;

        $bill::create([
            'cost' => $request->cost,
            'client_id' => $request->client_id,
            'reference_month' => $request->reference_month,
            'expiration_date' => $request->expiration_date,
            'created_at' => date("Y/m/d"),
            'billing_id' => null,
            'is_open' => true,
        ]);

    }

    public function show(Request $request, Bill $bill)
    {
        $bill = new BillResource($bill);
        return response()->json($bill, 200);
    }

    public function update(Request $request, Bill $bill)
    {
        $bill->update([
            'cost' => $request->cost,
            'client_id' => $request->client_id,
            'reference_month' => $request->reference_month,
            'expiration_date' => $request->expiration_date,
            'created_at' => $request->created_at,
            'billing_id' => $request->billing_id,
            'is_open' => $request->is_open,
        ]);

        return response('',200);
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();

        return response('',200);
    }
}
