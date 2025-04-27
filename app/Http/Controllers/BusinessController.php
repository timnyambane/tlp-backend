<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\RegisterBusinessRequest;
use App\Services\BusinessService;
use Illuminate\Http\JsonResponse;

class BusinessController extends Controller
{
    protected $businessService;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
    }

    public function register(RegisterBusinessRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $this->businessService->registerBusiness($validatedData);

            return ApiResponse::success([
            ], 'Business registered successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
}
