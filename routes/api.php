<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WorkCategoryController;
use App\Models\WorkCategory;
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
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
