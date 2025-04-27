<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'job_post_id',
        'business_id',
        'quote',
        'hired_date',
    ];

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
