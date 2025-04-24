<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return ApiResponse::validation($validator->errors(), 'Invalid input');
        }

        $creds = $request->only('email', 'password');
        $token = Auth::attempt($creds);

        if (!$token) {
            return ApiResponse::unauthorized('Invalid credentials');
        }

        return ApiResponse::success([
            'token' => $token,
        ], 'Login successful');
    }

    public function logout()
    {
        try {
            Auth::logout();

            return ApiResponse::success([], 'Logged out successfully');
        } catch (\Exception $e) {
            Log::error('Logout failed', ['error' => $e->getMessage()]);

            return ApiResponse::error('Logout failed. Please try again later.', 500);
        }
    }

    public function refresh()
    {
        try {
            $token = Auth::refresh();

            return ApiResponse::success([
                'token' => $token,
            ], 'Token refreshed successfully');
        } catch (\Exception $e) {
            Log::error('Token refresh failed', ['error' => $e->getMessage()]);

            return ApiResponse::error('Token refresh failed. Please try again later.', 401);
        }
    }

}
