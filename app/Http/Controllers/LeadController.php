<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $business = Auth::user()->business;

        if (!$business) {
            return ApiResponse::error('Business not found');
        }

        $serviceIds = $business->services->pluck('id');

        $leads = Lead::whereNull('business_id')
            ->whereHas('jobPost', function ($query) use ($serviceIds, $business) {
                $query->whereIn('service_id', $serviceIds)
                    ->where('location_id', $business->location_id);
            })
            ->with('jobPost.service', 'jobPost.location')
            ->paginate(10);

        $leads->getCollection()->transform(function ($lead) {
            return [
                'id' => $lead->id,
                'job_post_id' => $lead->job_post_id,
                'business_id' => $lead->business_id,
                'quote' => $lead->quote,
                'message' => $lead->message,
                'hired_date' => $lead->hired_date,
                'created_at' => $lead->created_at,
                'updated_at' => $lead->updated_at,
                'job_post' => [
                    'id' => $lead->jobPost->id,
                    'title' => $lead->jobPost->title,
                    'description' => $lead->jobPost->description,
                    'specific_date' => $lead->jobPost->specific_date,
                    'status' => $lead->jobPost->status,
                    'type' => $lead->jobPost->type,
                    'service' => $lead->jobPost->service->name ?? null,
                    'location' => $lead->jobPost->location->location ?? null,
                ],
            ];
        });

        return ApiResponse::success($leads, 'Relevant leads retrieved successfully');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
