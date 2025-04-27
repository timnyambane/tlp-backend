<?php

namespace App\Listeners;

use App\Events\JobPostCreated;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class CreateBusinessLead
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JobPostCreated $event): void
    {
        $jobPost = $event->jobPost;
        Lead::create([
            'job_post_id' => $jobPost->id,
            'business_id' => null,
            'quote' => null,
            'hired_date' => null,
        ]);
    }
}
