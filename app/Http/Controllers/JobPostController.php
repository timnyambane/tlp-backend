<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\JobPostRequest;
use App\Models\JobPost;
use App\Services\JobPostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{

    protected $jobPostsService;

    public function __construct(JobPostService $jobPostsService)
    {
        $this->jobPostsService = $jobPostsService;
    }

    public function index(): JsonResponse
    {
        $user = Auth::user();

        $status = request()->query('status');
        if (!$status) {
            return ApiResponse::error('Status parameter is required.');
        }

        try {
            $jobPosts = $this->jobPostsService->indexJobs($user->customer, $status);
            return ApiResponse::success($jobPosts, 'Job posts retrieved successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function store(JobPostRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = Auth::user();

        try {
            $this->jobPostsService->createJobPost($user, $validatedData);
            return ApiResponse::success(null, 'Job post created successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function show(JobPost $jobPost): JsonResponse
    {
        return ApiResponse::success($jobPost, 'Job post retrieved successfully.');
    }

    public function update(JobPostRequest $request, JobPost $jobPost): JsonResponse
    {
        $validatedData = $request->validated();

        $this->jobPostsService->updateJobPost($jobPost, $validatedData);

        return ApiResponse::success(null, 'Job post updated successfully.');
    }

    public function destroy(JobPost $jobPost): JsonResponse
    {
        $this->jobPostsService->deleteJobPost($jobPost);

        return ApiResponse::success(null, 'Job post deleted successfully.');
    }
}
