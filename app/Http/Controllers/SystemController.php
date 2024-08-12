<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{
    public function index()
    {
        $systems = System::all();
        return response()->json($systems, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $system = new System;

        $system::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function show(Request $request, System $system)
    {
        $system = $system->load(['client']);
        return response()->json($system, 200);
    }

    public function update(Request $request, System $system)
    {
        $system->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response('',200);
    }

    public function destroy(Request $request, System $system)
    {
        $system->delete();
        return response('',200);
    }
}
