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
        $billing = new BillingResource($billing);
        return response()->json($billing, 200);
    }

    public function update(Request $request, Billing $billing)
    {
        $request->validate([
            'bills' => 'required'
        ]);

        DB::transaction(function() use ($billing, $request){
            $billing->update([
                'name' => $request->name,
                'deploy_date' => $request->deploy_date,
                'end_contract_date' => $request->end_contract_date,
                'expiration_bill_date' => $request->expiration_bill_date,
                'bill_value' => $request->bill_value
            ]);
               
            $bills = Bill::find($request->bills);
            $existentBills = Bill::all()->where('billing_id', $billing->id);

            if($existentBills){
                foreach($existentBills as $existentBill){
                    $deleteBill = true;
                    foreach($bills as $bill){
                        if($bill == $existentBill) $deleteBill = false;
                    }

                    if($deleteBill){
                        $existentBill->billing_id = null;
                        $existentBill->is_open = true;
                        $existentBill->save();
                    }
                }
            }

            foreach($bills as $bill){
                if($bill->billing_id != $billing->id || $bill->is_open){
                    $bill->billing_id = $billing->id;
                    $bill->is_open = false;
                    $bill->save();
                }    
            }
        });
    }

    public function destroy(Billing $billing)
    {
        DB::transaction(function() use ($billing){
            $existentBills = Bill::all()->where('billing_id', $billing->id);
            foreach($existentBills as $existentBill){
                $existentBill->billing_id = null;
                $existentBill->is_open = true;
                $existentBill->save();
            }
            $billing->delete();
        });
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
