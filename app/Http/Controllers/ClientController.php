<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'deploy_date' => 'required',
            'end_contract_date' => 'required',
            'expiration_bill_date' =>  'required',
            'bill_value' => 'required',
        ]);

        $client = new Client;

        $client::create([
            'name' => $request->name,
            'deploy_date' => $request->deploy_date,
            'end_contract_date' => $request->end_contract_date,
            'expiration_bill_date' => $request->expiration_bill_date,
            'bill_value' => $request->bill_value
        ]);
    }

    public function show(Request $request, Client $client)
    {
        $client = $client->load(['system']);
        return response()->json($client, 200);
    }

    public function update(Request $request, Client $client)
    {
        $client->update([
            'name' => $request->name,
            'deploy_date' => $request->deploy_date,
            'end_contract_date' => $request->end_contract_date,
            'expiration_bill_date' => $request->expiration_bill_date,
            'bill_value' => $request->bill_value
        ]);

        return response('',200);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response('',200);
    }

    public function updateSystemsToClient(Request $request, Client $client){
        DB::transaction(function () use ($request, $client){
            $existentSystems = $client->system()->get();
            if(count($existentSystems)){
                foreach($existentSystems as $existentSystem){
                    $deleteSystem = true;
                    foreach($request->systems as $system){
                        if($existentSystem->id == $system) $deleteSystem = false;
                    }

                    if($deleteSystem){
                        $client->system()->detach($existentSystem);
                    }
                }
            }

            foreach($request->systems as $system){
                $createBill = true;
                if(count($existentSystems)){
                    foreach($existentSystems as $existent){
                        if($existent->id == $system) $createBill = false;
                    }
                }

                if($createBill) $client->system()->attach($system);
            }

        }); 

        return response('', 200);
    }
}
