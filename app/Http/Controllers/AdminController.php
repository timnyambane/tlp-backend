<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Business;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function allCustomers(): JsonResponse
    {
        $customers = Customer::with(['user:id,first_name,last_name,email'])
            ->paginate(10);

        return ApiResponse::success($customers, 'Customers retrieved successfully');
    }

    public function allBusinesses(): JsonResponse
    {
        $customers = Business::with(['user:id,first_name,last_name,email'])
            ->paginate(10);

        return ApiResponse::success($customers, 'Business retrieved successfully');
    }
}
