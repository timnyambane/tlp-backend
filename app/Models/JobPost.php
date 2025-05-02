<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function work_category(): BelongsTo
    {
        return $this->belongsTo(WorkCategory::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function lead(): HasOne
    {
        return $this->hasOne(Lead::class);
    }
}
