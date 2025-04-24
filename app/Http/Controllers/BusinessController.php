<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\RegisterBusinessRequest;
use App\Models\Service;
use App\Models\User;

class BusinessController extends Controller
{
    public function register(RegisterBusinessRequest $request)
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
                'role' => config('constants.roles.business'),
            ]);

            $business = $user->business()->create([
                'location_id' => $validatedData['location_id'],
                'work_category_id' => $validatedData['work_category_id'],
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'],
            ]);

            $workCategoryId = $validatedData['work_category_id'];
            $services = Service::whereIn('id', $validatedData['services'])
                ->where('work_category_id', $workCategoryId)
                ->get();

            if ($services->count() !== count($validatedData['services'])) {
                return ApiResponse::error('Some selected services do not belong to the same work category.', 400);
            }

            $business->services()->sync($validatedData['services']);

            return ApiResponse::success([
                'user' => $user,
                'business' => $business,
            ], 'Business registered successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error('An error occurred while registering the business.' . $e->getMessage(), 500);
        }
    }
}
