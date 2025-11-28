<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormat;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ResponseFormat::success(200, "List of Cities", City::all());
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = $request->validate([
                'city_name' => 'required|string|unique:cities',
                'city_code' => 'required|string|unique:cities',
                'province_id' => 'required|integer|exists:provinces',
            ]);

            if ($validator) {
                $province = City::create([
                    'city_name' => $request->city_name,
                    'city_code' => $request->city_code,
                    'province_id' => $request->province_id,
                ]);
                return ResponseFormat::success(200, "City created successfully", $province);
            }
            return ResponseFormat::badRequest("City creation failed");

        } catch (\Exception $e) {
            return ResponseFormat::serverError($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {

        try {
            return ResponseFormat::success(200, "City details", $city);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        try {
            $city->update($request->only(['city_name', 'city_code', 'province_id']));
            return ResponseFormat::success(200, "City updated successfully", $city);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        try {
            $city->delete();
            return ResponseFormat::success(200, "City deleted successfully");
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    // Additional Function

    public function getCitiesByProvince($province_id)
    {
        try {
            $cities = City::whereHas('province', function ($query) use ($province_id) {
                $query->where('province_id', $province_id);
            })->get();
            return ResponseFormat::success(200, "List of Cities", $cities);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }
}
