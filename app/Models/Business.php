<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Business extends Model
{
    protected $fillable = [
        'location_id',
        'work_category_id',
        "name",
        "address",
        "phone",
        "website",
        "description",
        "logo",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    public function workCategory(): BelongsTo
    {
        return $this->belongsTo(WorkCategory::class);
    }
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
