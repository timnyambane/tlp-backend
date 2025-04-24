<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\RegisterCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function register(RegisterCustomerRequest $request)
    {
        $validatedData = $request->validated();

        $fullName = explode(' ', $validatedData['full_name']);
        $firstName = $fullName[0];

        $lastName = isset($fullName[1]) ? $fullName[1] : '';

        try {
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'role' => config('constants.roles.customer'),
            ]);
            $user->customer()->create([
                'phone' => $validatedData['phone'],
            ]);

            return ApiResponse::success([
                'user' => $user,
            ], 'Customer registered successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred while registering the customer: ' . $e->getMessage());
        }
    }

}
