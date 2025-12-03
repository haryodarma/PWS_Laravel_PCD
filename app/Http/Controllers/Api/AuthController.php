<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormat;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// Auth
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 6 characters',
        ]);

        if ($validator->fails()) {
            return ResponseFormat::badRequest($validator->errors()->first());
        }
        if (!Auth::attempt($credentials)) {
            return ResponseFormat::badRequest("Invalid credentials");
        }
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ResponseFormat::badRequest("Invalid credentials");
            }
        } catch (JWTException $e) {
            return ResponseFormat::serverError("Could not create token");
        }

        $expiry = Carbon::now()->addMinutes(config('jwt.ttl'));


        return ResponseFormat::success(200, "Login successful", ['token' => $token, 'expires_at' => $expiry->toDateTimeString()]);
    }

    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            // $user = "Heabrain";
            return ResponseFormat::success(200, "User details fetched successfully", $user);
        } catch (JWTException $e) {
            return ResponseFormat::unauthorized("Token is invalid");
        }
    }

    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            $expiry = Carbon::now()->addMinutes(config('jwt.ttl'));
            return ResponseFormat::success(200, "Token refreshed successfully", ['token' => $newToken, 'expires_at' => $expiry->toDateTimeString()]);
        } catch (JWTException $e) {
            return ResponseFormat::unauthorized("Token is invalid");
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();
            return ResponseFormat::success(200, "User logged out successfully");
        } catch (JWTException $e) {
            return ResponseFormat::unauthorized("Token is invalid");
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return ResponseFormat::badRequest($validator->errors()->first());
        }

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return ResponseFormat::success(200, "User registered successfully", $user);
    }
}
