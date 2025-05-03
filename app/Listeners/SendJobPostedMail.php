<?php

namespace App\Listeners;

use App\Events\JobPostCreated;
use App\Mail\JobPostedMail;
use Illuminate\Support\Facades\Mail;

class SendJobPostedMail
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

        Mail::to('admin@gmail.com')
            ->send(new JobPostedMail($jobPost, 'mails.admin-job-posted'));
        Mail::to($jobPost->customer->user->email)
            ->send(new JobPostedMail($jobPost, 'mails.job-posted'));


    }
}
