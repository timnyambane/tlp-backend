<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'town',
        'location',
        'country_string',
        'eastings',
        'country',
        'region',
        'longitude',
        'uk_region',
        'postcode',
        'latitude',
        'northings',
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
