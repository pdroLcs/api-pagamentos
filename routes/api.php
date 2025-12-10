<?php

use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TesteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {
    Route::get('users', [UserController::class, 'index']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/users/{user}', [UserController::class, 'show'])->middleware('ability:user-get');
        Route::get('/teste', [TesteController::class, 'index'])->middleware('ability:teste-index');
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    
    Route::apiResource('invoices', InvoiceController::class)->middlewareFor(
        ['update', 'store'], ['auth:sanctum', 'abilities:invoice-store,user-update']);


});

//7|LhYYDGheYQdJ1ZZMB2OGic0GQOJyESL1xO3AyUIk7aa70588 Invoice
//6|jTwRWyCc0PJv38CEVtyiVSrDIb4iJuMDmIaY4sv8fb5a45f3 User
//8|F4tozlwFIQEN8xtMMj6mK50mNgJaEub4vD4WW3Rnaab974c9 Teste