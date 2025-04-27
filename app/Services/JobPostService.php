<?php

namespace App\Services;

use App\Events\JobPostCreated;
use App\Models\JobPost;
use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;

class JobPostService
{
    public function indexJobs(Customer $customer, ?string $status = null): LengthAwarePaginator
    {
        $query = JobPost::where('customer_id', $customer->id)
            ->with([
                'location:id,location',
                'work_category:id,name',
                'service:id,name',
            ]);

        if ($status) {
            $validStatuses = config('constants.job_status');
            if (!array_key_exists($status, $validStatuses)) {
                throw new Exception("Invalid job status provided.");
            }
            $query->where('status', $status);
        }

        return $query->paginate(10)->through(function (JobPost $jobPost) {
            return [
                'id' => $jobPost->id,
                'title' => $jobPost->title,
                'description' => $jobPost->description,
                'urgency' => $jobPost->urgency,
                'specific_date' => $jobPost->specific_date,
                'status' => $jobPost->status,
                'type' => $jobPost->type,
                'created_at' => $jobPost->created_at,
                'updated_at' => $jobPost->updated_at,
                'location' => $jobPost->location->location ?? null,
                'work_category' => $jobPost->work_category->name ?? null,
                'service' => $jobPost->service->name ?? null,
            ];
        });
    }


    public function createJobPost(?User $user, array $validatedData): JobPost
    {
        $specificDate = ($validatedData['urgency'] === 'specificDate') ? $validatedData['specific_date'] : null;

        $data = [
            'location_id' => $validatedData['location_id'],
            'work_category_id' => $validatedData['work_category_id'],
            'service_id' => $validatedData['service_id'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'] ?? config('constants.job_status.open'),
            'urgency' => $validatedData['urgency'],
            'specific_date' => $specificDate,
            'type' => $validatedData['type'] ?? config('constants.job_type.standard'),
        ];

        try {
            $jobPost = $user->customer->job_posts()->create($data);
            event(new JobPostCreated($jobPost));

            return $jobPost;
        } catch (Throwable $e) {
            throw new Exception('Failed to create job post.' . $e->getMessage());
        }
    }

    public function updateJobPost(JobPost $jobPost, array $data): bool
    {
        try {
            return $jobPost->update($data);
        } catch (Throwable $e) {
            throw new Exception('Failed to update job post.' . $e->getMessage());
        }
    }

    /**
     * Delete a job post.
     */
    public function deleteJobPost(JobPost $jobPost): bool
    {
        try {
            return (bool) $jobPost->delete();
        } catch (Throwable $e) {
            throw new Exception('Failed to delete job post.' . $e->getMessage());
        }
    }
}
