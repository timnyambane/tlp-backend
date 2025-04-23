<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkCategory extends Model
{
    protected $fillable = [
        'name',
        'active',
    ];

    public $timestamps = false;

    protected $casts = [
        'active' => 'boolean',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
