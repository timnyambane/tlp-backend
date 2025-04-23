<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function workCategory()
    {
        return $this->belongsTo(WorkCategory::class);
    }

}
