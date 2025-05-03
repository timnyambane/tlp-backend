<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WorkCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/locations', [LocationController::class, 'index']);

Route::prefix('categories')->controller(WorkCategoryController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'storeCategory');
    Route::get('{workCategory}', 'show');
    Route::put('{workCategory}', 'updateCategory');
    Route::delete('{workCategory}', 'destroyCategory');
});

Route::prefix('services')->controller(WorkCategoryController::class)->group(function () {
    Route::post('/', 'storeService');
    Route::put('{serviceId}', 'updateService');
    Route::delete('{serviceId}', 'destroyService');
});

Route::post('login', [AuthController::class, 'login']);
Route::post('customer/register', [CustomerController::class, 'register']);
Route::post('business/register', [BusinessController::class, 'register']);


Route::middleware('auth:api')->group(function () {

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh-token', 'refresh');
    });

    // Customer-only routes
    Route::prefix('customer')->middleware('customer')->group(function () {
        Route::apiResource('job-posts', JobPostController::class);
    });

    // Business-only routes
    Route::prefix('business')->middleware('business')->group(function () {
        Route::apiResource('leads', LeadController::class);
    });

    // Admin-only routes
    Route::prefix('admin')->middleware('admin')->controller(AdminController::class)->group(function () {
        Route::get('customers', 'allCustomers');
        Route::get('businesses', 'allBusinesses');
    });
});
