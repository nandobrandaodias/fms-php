<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'system'], function(){
    Route::get('/', [SystemController::class, 'index']);
    Route::get('/show/{system}', [SystemController::class, 'show']);
    Route::post('/store', [SystemController::class, 'store']);
    Route::patch('/update/{system}', [SystemController::class, 'update']);
    Route::delete('/delete/{system}', [SystemController::class, 'destroy']);
});

Route::group(['prefix' => 'client'], function(){
    Route::get('/', [ClientController::class, 'index']);
    Route::get('/show/{client}', [ClientController::class, 'show']);
    Route::post('/updateSystemsToClient/{client}', [ClientController::class, 'updateSystemsToClient']);
    Route::post('/store', [ClientController::class, 'store']);
    Route::patch('/update/{client}', [ClientController::class, 'update']);
    Route::delete('/delete/{client}', [ClientController::class, 'destroy']);
});

Route::group(['prefix' => 'billing'], function(){
    Route::get('/', [BillingController::class, 'index']);
    Route::get('/show/{billing}', [BillingController::class, 'show']);
    Route::post('/store', [BillingController::class, 'store']);
    Route::patch('/update/{billing}', [BillingController::class, 'update']);
    Route::delete('/delete/{billing}', [BillingController::class, 'destroy']);
});

Route::group(['prefix' => 'bill'], function(){
    Route::get('/', [BillController::class, 'index']);
    Route::get('/show/{bill}', [BillController::class, 'show']);
    Route::post('/store', [BillController::class, 'store']);
    Route::patch('/update/{bill}', [BillController::class, 'update']);
    Route::delete('/delete/{bill}', [BillController::class, 'destroy']);
});

Route::group(['prefix' => 'payment'], function(){
    Route::get('/', [PaymentController::class, 'index']);
    Route::get('/show/{payment}', [PaymentController::class, 'show']);
    Route::post('/store', [PaymentController::class, 'store']);
    Route::patch('/update/{payment}', [PaymentController::class, 'update']);
    Route::delete('/delete/{payment}', [PaymentController::class, 'destroy']);
});