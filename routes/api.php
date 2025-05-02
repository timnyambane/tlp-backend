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
Route::prefix('categories')->group(function () {
    Route::get('/', [WorkCategoryController::class, 'index']);
    Route::post('/', [WorkCategoryController::class, 'storeCategory']);
    Route::get('{workCategory}', [WorkCategoryController::class, 'show']);
    Route::put('{workCategory}', [WorkCategoryController::class, 'updateCategory']);
    Route::delete('{workCategory}', [WorkCategoryController::class, 'destroyCategory']);
});
Route::prefix('services')->group(function () {
    Route::post('/', [WorkCategoryController::class, 'storeService']);
    Route::put('{serviceId}', [WorkCategoryController::class, 'updateService']);
    Route::delete('{serviceId}', [WorkCategoryController::class, 'destroyService']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('customer/register', [CustomerController::class, 'register']);
Route::post('business/register', [BusinessController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh-token', [AuthController::class, 'refresh']);

    Route::apiResource('job-posts', JobPostController::class)->middleware('customer');
    Route::apiResource('leads', LeadController::class)->middleware('business');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('customers', [AdminController::class, 'allCustomers']);
        Route::get('businesses', [AdminController::class, 'allBusinesses']);
    });
});
