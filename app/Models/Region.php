<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends MainModel
{
    protected $fillable = [
        'name',
        'city_id',
        'active',
        'order_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
