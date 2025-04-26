<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\JobPostRequest;
use App\Models\JobPost;
use App\Services\JobPostService;
use Illuminate\Support\Facades\Auth;

class JobPostController extends Controller
{

    protected $jobPostsService;

    public function __construct(JobPostService $jobPostsService)
    {
        $this->jobPostsService = $jobPostsService;
    }

    public function index()
    {
        $user = Auth::user();

        $user = Auth::user();
        if (!$user->customer || $user->customer->id !== $user->customer->id) {
            return ApiResponse::unauthorized('You are not authorized to view this job post.');
        }

        $jobPosts = $this->jobPostsService->indexJobs($user->customer);

        return ApiResponse::success($jobPosts, 'Job posts retrieved successfully.');
    }

    public function store(JobPostRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();
        if (!$user->customer) {
            return ApiResponse::unauthorized('Not a customer');
        }


        try {
            $this->jobPostsService->createJobPost($user, $validatedData);
            return ApiResponse::success(null, 'Job post created successfully.');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function show(JobPost $jobPost)
    {
        $user = Auth::user();
        if ($user->customer->id !== $jobPost->customer_id) {
            return ApiResponse::unauthorized('This job post does not belong to this account.');
        }

        return ApiResponse::success($jobPost, 'Job post retrieved successfully.');
    }

    public function update(JobPostRequest $request, JobPost $jobPost)
    {
        $user = Auth::user();
        if (!$user->customer || $user->customer->id !== $jobPost->customer_id) {
            return ApiResponse::unauthorized('You are not authorized to update this job post.');
        }

        $validatedData = $request->validated();

        $this->jobPostsService->updateJobPost($jobPost, $validatedData);

        return ApiResponse::success(null, 'Job post updated successfully.');
    }

    public function destroy(JobPost $jobPost)
    {
        $user = Auth::user();
        if (!$user->customer || $user->customer->id !== $jobPost->customer_id) {
            return ApiResponse::unauthorized('You are not authorized to delete this job post.');
        }

        $this->jobPostsService->deleteJobPost($jobPost);

        return ApiResponse::success(null, 'Job post deleted successfully.');
    }
}
