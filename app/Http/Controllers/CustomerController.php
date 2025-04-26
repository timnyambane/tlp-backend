<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\RegisterCustomerRequest;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    public function register(RegisterCustomerRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $this->customerService->registerCustomer($validatedData);

            return ApiResponse::success([
            ], 'Customer registered successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }

    }

}
