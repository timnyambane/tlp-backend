<?php

namespace App\Services;

use App\Models\JobPost;
use Exception;

class JobPostService
{
    public function indexJobs($customer)
    {
        return JobPost::where('customer_id', $customer->id)
            ->with([
                'location:id,location',
                'work_category:id,name',
                'service:id,name',
            ])
            ->paginate(10)
            ->through(function ($jobPost) {
                return [
                    'id' => $jobPost->id,
                    'customer_id' => $jobPost->customer_id,
                    'title' => $jobPost->title,
                    'description' => $jobPost->description,
                    'urgency' => $jobPost->urgency,
                    'specific_date' => $jobPost->specific_date,
                    'status' => $jobPost->status,
                    'type' => $jobPost->type,
                    'created_at' => $jobPost->created_at,
                    'updated_at' => $jobPost->updated_at,
                    'location' => $jobPost->location->location,
                    'work_category' => $jobPost->work_category->name,
                    'service' => $jobPost->service->name,
                ];
            });
    }


    public function createJobPost($user, $validatedData)
    {
        try {
            $user->customer->job_posts()->create([
                'location_id' => $validatedData['location_id'],
                'work_category_id' => $validatedData['work_category_id'],
                'service_id' => $validatedData['service_id'],
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'status' => $validatedData['status'] || config('constants.job_status.open'),
                'urgency' => $validatedData['urgency'],
                'specific_date' => $validatedData['specific_date'],
                'type' => $validatedData['type'] || config('constants.job_type.standard'),
            ]);
        } catch (Exception $e) {
            throw new Exception('Failed to create job post: ' . $e->getMessage());
        }
    }

    public function updateJobPost($jobPost, $data)
    {
        try {
            $jobPost->update($data);
        } catch (Exception $e) {
            throw new Exception('Failed to update job post: ' . $e->getMessage());
        }
    }

    public function deleteJobPost($jobPost)
    {
        try {
            $jobPost->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete job post: ' . $e->getMessage());
        }
    }
}
