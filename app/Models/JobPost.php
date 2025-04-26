<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'location_id',
        'work_category_id',
        'service_id',
        'title',
        'description',
        'status',
        'urgency',
        'specific_date',
        'type'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function work_category()
    {
        return $this->belongsTo(WorkCategory::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
