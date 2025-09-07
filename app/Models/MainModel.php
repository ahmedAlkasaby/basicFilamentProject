<?php

namespace App\Models;

use App\Traits\ActivityLogTrait;
use App\Traits\HasTrash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainModel extends Model
{
    use HasFactory, SoftDeletes, ActivityLogTrait,HasTrash;

    protected $casts = [
        'name' => \App\Casts\UnescapedJson::class,
        'description' => \App\Casts\UnescapedJson::class,
    ];


    public function nameLang($lang = null)
    {
        $data = $this->name;
        if ($lang === null) {

            $defaultLang = app()->getLocale();
            return $data[$defaultLang] ?? null;
        }
        return $data[$lang] ?? null;
    }

    public function descriptionLang($lang = null)
    {
        $data = $this->description;
        if ($lang === null) {

            $defaultLang = app()->getLocale();
            return  $data[$defaultLang] ?? null;
        }
        return $data[$lang] ?? null;
    }

    public function scopeNewest($query)
    {
        return $query->orderByDesc('id');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('id');
    }

    public function scopeOrderNo($query)
    {
        return $query->orderByRaw('order_id IS NULL') 
                     ->orderBy('order_id', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)->orderNo();
    }

}
