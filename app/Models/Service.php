<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{

    protected $fillable = [
        'work_category_id',
        'name',
        'active',
    ];

    public $timestamps = false;

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $hidden = [
        'work_category_id',
    ];

    public function workCategory(): BelongsTo
    {
        return $this->belongsTo(WorkCategory::class);
    }

    public function businesses(): BelongsToMany
    {
        return $this->belongsToMany(Business::class);
    }

}
