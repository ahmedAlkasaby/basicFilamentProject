<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends MainModel
{
    protected $fillable = [
        'name',
        'active',
        'order_id',
    ];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
     public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function activeRegions()
    {
        return $this->hasMany(Region::class)->where('active', true)->orderBy('order_id');
    }
   




}
