<?php

use Illuminate\Support\Facades\Route;

Route::get("/test", function () {
    return response()->json(["message" => "API is working"]);
});

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



