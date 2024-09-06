<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/booking/store', [BookingController::class, 'store']);
    Route::post('/bookingshow', [BookingController::class, 'show']);
    Route::post('/bookingsupdate/{id}', [BookingController::class, 'update']);
    Route::get('/bookingsdelete/{id}', [BookingController::class, 'destroy']);
    Route::post('/addService', [ServiceController::class, 'storeService']);
    Route::post('/addProvider', [ProviderController::class, 'addProvider']);
    Route::post('/providers/search', [ProviderController::class, 'search']);
});
