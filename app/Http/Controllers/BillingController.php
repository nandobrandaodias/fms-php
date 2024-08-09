<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillingResource;
use App\Models\Bill;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::all();
        return response()->json($billings, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'reference_month' => 'required',
        ]);

        if($request?->bills){
            DB::transaction(function () use ($request) {
                $billing = Billing::create([
                    'user_id' => $request->user_id,
                    'reference_month' => $request->reference_month,
                    'created_at' => date("Y/m/d"),
                    'is_approved' => false
                ]);

                foreach($request->bills as $bill){
                    $bill = Bill::where('id',$bill)->first();
                    $bill->billing_id = $billing->id;
                    $bill->is_open = false;
                    $bill->save();
                }
            });
            return response('ok',200);
        }
    }

    public function show(Request $request, Billing $billing)
    {
        $billing = new BillingResource(Bill::findOrFail($billing));
        return response()->json($billing, 200);
    }

    public function update(Request $request, Billing $billing)
    { 
        //
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();
        return response('', 200);
    }

    public function approveBilling(Request $request, Billing $billing){
        DB::transaction(function() use ($billing){
            $billing->is_approved = true;
            $billing->save();
        });
        return response('', 200);
    }
}
