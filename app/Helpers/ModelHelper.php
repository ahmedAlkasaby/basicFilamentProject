<?php

namespace App\Helpers;

class ModelHelper{
    public static function models(){
    return  [
            'App\Models\City'=>__('tables.cities'),
            'App\Models\Region'=>__('tables.regions'),
            'App\Models\Location'=>__('tables.locations'),
            'App\Models\User'=>__('tables.users'),
            'App\Models\ActivityLog'=>__('tables.activity_logs'),
        ];

    }


    public static function actions(){
    return  [
            'created'=>__('site.created'),
            'updated'=>__('site.updated'),
            'deleted'=>__('site.deleted'),
            'restored'=>__('site.restored'),
            'forceDeleted'=>__('site.forceDeleted'),
            'activated'=>__('site.activated'),
        ];

    }
}
