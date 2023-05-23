<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\FamilyController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

//------------------------------------------------------------
// Protected Routes
//------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('cities', CityController::class);
    Route::apiResourceWithSoftDeletes('families', FamilyController::class);
    Route::apiResourceWithSoftDeletes('invoices', InvoiceController::class);

    Route::post('logout', [AuthController::class, 'logout']);
});
