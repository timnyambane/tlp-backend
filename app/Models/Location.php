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
}
