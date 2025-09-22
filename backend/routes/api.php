<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('/user', function () {
    return response()->json([
        'message' => 'API is working'
    ]);
});

Route::apiResource('suppliers', SupplierController::class);
