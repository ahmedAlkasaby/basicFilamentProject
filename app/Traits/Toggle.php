<?php

namespace App\Traits;

use App\Models\City;
use App\Models\Page;
use App\Models\Role;
use App\Models\Size;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Region;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Service;
use App\Models\Addition;
use App\Models\Category;
use App\Models\DeliveryTime;
use Illuminate\Database\Eloquent\Model;

trait Toggle
{
    public function active(Model $model)
    {   
       
        if(!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Model not found',
            ]);
        }
        $model->update([
            'active' => !$model->active
        ]);

        return response()->json([
            'success' => true,
            'active' => $model->active,
        ]);
    }
    
}
