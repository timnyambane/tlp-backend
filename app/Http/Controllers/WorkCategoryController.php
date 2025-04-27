<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Service;
use App\Models\WorkCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class WorkCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $workCategories = WorkCategory::with('services')->get();
            return ApiResponse::success($workCategories, 'Work categories retrieved successfully.');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to retrieve work categories: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created category in storage.
     */
    public function storeCategory(Request $request): JsonResponse
    {
        try {
            $creds = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:work_categories,name',
            ]);

            if ($creds->fails()) {
                return ApiResponse::validation($creds->errors());
            }
            $workCategory = WorkCategory::create($creds->validated());
            return ApiResponse::success($workCategory, 'Work category created successfully.');
        } catch (Exception $e) {
            return ApiResponse::validation('Failed to create work category: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created service in storage.
     */
    public function storeService(Request $request): JsonResponse
    {
        try {
            $creds = Validator::make($request->all(), [
                'work_category_id' => 'required|exists:work_categories,id',
                'services' => 'required|array|min:1',
                'services.*.name' => 'required|string',
            ]);

            if ($creds->fails()) {
                return ApiResponse::validation($creds->errors());
            }

            $services = [];
            foreach ($request->services as $serviceData) {
                $services[] = Service::create([
                    'name' => $serviceData['name'],
                    'work_category_id' => $request->work_category_id,
                    'active' => $serviceData['active'] ?? true,
                ]);
            }

            return ApiResponse::success($services, 'Services created successfully.');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to create service: ' . $e->getMessage());
        }
    }

    /**
     * Search for categories based on query parameters.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = WorkCategory::with('services');

            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->has('active')) {
                $query->where('active', $request->active);
            }

            $workCategories = $query->get();

            return ApiResponse::success($workCategories, 'Work categories retrieved based on search.');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to search work categories: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified category in storage.
     */
    public function updateCategory(Request $request, $id): JsonResponse
    {
        $creds = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:work_categories,name,' . $id,
            'active' => 'boolean',
        ]);

        if ($creds->fails()) {
            return ApiResponse::validation($creds->errors());
        }

        try {
            $workCategory = WorkCategory::find($id);

            if (!$workCategory) {
                return ApiResponse::error('Work category not found.', 404);
            }

            $workCategory->update($creds->validated());
            return ApiResponse::success($workCategory, 'Work category updated successfully.');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to update work category: ' . $e->getMessage());
        }
    }



    /**
     * Update a service inside a category.
     */
    public function updateService(Request $request, $serviceId): JsonResponse
    {
        $creds = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'active' => 'boolean',
        ]);

        if ($creds->fails()) {
            return ApiResponse::validation($creds->errors());
        }

        try {
            $service = Service::find($serviceId);

            if (!$service) {
                return ApiResponse::error('Service not found.', 404);
            }

            $service->update($creds->validated());
            return ApiResponse::success($service, 'Service updated successfully.');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to update service: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroyCategory($id): JsonResponse
    {
        try {
            $workCategory = WorkCategory::find($id);

            if (!$workCategory) {
                return ApiResponse::error('Work category not found.', 404);
            }

            if ($workCategory->services()->exists()) {
                return ApiResponse::error('Category cannot be deleted because it has associated services.', 400);
            }

            $workCategory->delete();
            return ApiResponse::success([], 'Work category deleted successfully.');

        } catch (Exception $e) {
            return ApiResponse::error('Failed to delete work category: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified service from storage.
     */
    public function destroyService($serviceId): JsonResponse
    {
        try {
            $service = Service::find($serviceId);
            if (!$service) {
                return ApiResponse::error('Service not found.', 404);
            }
            $service->delete();
            return ApiResponse::success([], 'Service deleted successfully.');
        } catch (Exception $e) {
            return ApiResponse::error('Failed to delete service: ' . $e->getMessage());
        }
    }
}
