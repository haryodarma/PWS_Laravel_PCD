<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormat;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ResponseFormat::success(200, "List of Districts", District::all());
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = $request->validate([
                'district_name' => 'required|string',
                'district_code' => 'required|string',
                'city_id' => 'required',
            ]);

            if ($validator) {
                $district = District::create([
                    'district_name' => $request->district_name,
                    'district_code' => $request->district_code,
                    'city_id' => $request->city_id,
                ]);
                return ResponseFormat::success(200, "District created successfully", $district);
            }
            return ResponseFormat::badRequest("District creation failed");

        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(District $district)
    {
        try {
            return ResponseFormat::success(200, "District details", $district);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        try {
            $district->update($request->only(['district_name', 'district_code', 'city_id']));
            return ResponseFormat::success(200, "District updated successfully", $district);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(District $district)
    {
        try {
            $district->delete();
            return response()->json(["message" => "District deleted successfully"]);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }
    // Additional Function
    public function getDistrictsByCity($city_id)
    {
        try {
            $districts = District::whereHas('city', function ($query) use ($city_id) {
                $query->where('city_id', $city_id);
            })->get();
            return ResponseFormat::success(200, "List of Districts", $districts);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }
}
