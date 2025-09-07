<?php
namespace App\Traits;

use App\Models\TrashBucket;

trait HasTrash
{

    public static function bootHasTrash()
    {
        static::deleted(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                $exists = TrashBucket::where('model_type', get_class($model))
                    ->where('model_id', $model->id)
                    ->exists();

                if (! $exists) {
                    TrashBucket::create([
                        'model_type' => get_class($model),
                        'model_id' => $model->id,
                        'user_id'=> auth()->id() 
                    ]);
                }
            }
        });

        static::restored(function ($model) {
            TrashBucket::where('model_type', get_class($model))
                ->where('model_id', $model->id)
                ->delete();
        });
    }
}
