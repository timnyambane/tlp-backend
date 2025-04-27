<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $fillable = [
        "phone",
        "photo"
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function job_posts(): HasMany
    {
        return $this->hasMany(JobPost::class);
    }
}
