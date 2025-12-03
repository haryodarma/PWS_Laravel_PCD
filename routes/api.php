<?php

use Illuminate\Support\Facades\Route;

Route::get("/test", function () {
    return response()->json(["message" => "API is working"]);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

});

Route::middleware(["jwt.auth"])->group(function () {
    Route::get('/me', [App\Http\Controllers\Api\AuthController::class, 'me']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('/refresh', [App\Http\Controllers\Api\AuthController::class, 'refresh']);

    Route::prefix('provinces')->group(function () {
        Route::resource('', App\Http\Controllers\ProvinceController::class)->parameters(['' => 'province']);
    });

    Route::prefix('cities')->group(function () {
        Route::resource('', App\Http\Controllers\CityController::class)->parameters(['' => 'city']);
        Route::get('/by-province/{province_id}', [App\Http\Controllers\CityController::class, 'getCitiesByProvince']);
    });

    Route::prefix('districts')->group(function () {
        Route::resource('', App\Http\Controllers\DistrictController::class)->parameters(['' => 'district']);
        Route::get('/by-city/{city_id}', [App\Http\Controllers\DistrictController::class, 'getDistrictsByCity']);
    });
});



