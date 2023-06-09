<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\FamilyController;
use App\Http\Controllers\Api\FamilyInvoicesController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);

//------------------------------------------------------------
// Protected Routes
//------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('home', HomeController::class);

    // Users Routes
    Route::apiResourceWithSoftDeletes('users', UserController::class, ['except' => ['forceDelete', 'trash']]);

    // Cities Routes
    Route::apiResource('cities', CityController::class);

    // Families Routes
    Route::apiResourceWithSoftDeletes('families', FamilyController::class, ['except' => ['forceDelete']]);
    Route::get('/families/{family}/invoices', FamilyInvoicesController::class);

    // Invoices Routes
    Route::apiResourceWithSoftDeletes('invoices', InvoiceController::class, ['except' => ['trash']]);

    // Auth Routes
    Route::post('auth/logout', [AuthController::class, 'logout']);

    // Profile Routes
    Route::get('profile/details', [ProfileController::class, 'details']);
    Route::put('profile/update', [ProfileController::class, 'update']);
});
