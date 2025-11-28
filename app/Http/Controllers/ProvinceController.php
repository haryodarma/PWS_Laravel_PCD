<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormat;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return ResponseFormat::success(200, "List of Provinces", Province::all());
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {

            $validator = $request->validate([
                'province_name' => 'required|string|unique:provinces,province_name',
                'province_code' => 'required|string|unique:provinces,province_code',
            ]);
            if ($validator) {
                $province = Province::create([
                    'province_name' => $request->province_name,
                    'province_code' => $request->province_code,
                ]);
                return ResponseFormat::success(200, "Province created successfully", $province);
            }
            return ResponseFormat::badRequest("Province creation failed");

        } catch (\Exception $e) {
            return ResponseFormat::serverError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province)
    {
        try {
            return ResponseFormat::success(200, "Province details", $province);
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        try {

        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        try {
            if ($request->has('province_name')) {
                $province->province_name = $request->province_name;
            }
            if ($request->has('province_code')) {
                $province->province_code = $request->province_code;
            }
            $province->save();
            return ResponseFormat::success(200, "Province updated successfully", $province);

        } catch (\Exception $e) {
            return ResponseFormat::serverError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        try {

            $province->delete();
            return ResponseFormat::success(200, "Province deleted successfully");
        } catch (\Exception $e) {
            return ResponseFormat::serverError();
        }
    }
}
