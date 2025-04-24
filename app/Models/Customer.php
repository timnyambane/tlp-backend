<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        "phone",
        "photo"
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
