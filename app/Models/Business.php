<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function workCategory()
    {
        return $this->belongsTo(WorkCategory::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
