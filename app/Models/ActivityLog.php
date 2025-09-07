<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'action',
        'changes',
        'ip_address',
        'user_agent',
    ];


    protected $casts = [
        'changes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->where('type', 'admin');
    }

    public function model()
    {
        return $this->morphTo();
    }


    // public function scopeFilter($query, $request = null)
    // {
    //     $request = $request ?? request();
    //     $query->orderBy('created_at', 'desc');

    //     if ($request->has('user_id') && $request->user_id != 'all') {
    //         $query->where('user_id', $request->user_id);
    //     }

    //     if ($request->has('model_type') && $request->model_type != 'all') {
    //         $query->where('model_type', $request->model_type);
    //     }

    //     if ($request->has('action') && $request->action != 'all') {
    //         $query->where('action', $request->action);
    //     }
    //     return $query;
    // }


    public function findTable()
    {
        if (!class_exists($this->model_type)) {
            throw new \Exception("Model class '{$this->model_type}' not found.");
        }

        return (new $this->model_type)->getTable();
    }

    public function formatChangeValue($modelInstance, string $attribute, $value): string
    {
        
        if (Str::endsWith($attribute, '_id')) {
            $relationName = Str::camel(Str::before($attribute, '_id'));
    
            if (method_exists($modelInstance, $relationName)) {
                try {
                    $related = $modelInstance->$relationName()->getRelated();
                    $relatedModel = $related->find($value);

    
                    return $relatedModel?->nameLang()
                    ?? $relatedModel?->name
                    ?? (string) $value;
                } catch (\Exception $e) {
                    return (string) $value;
                }
            }
        }
    
        return is_scalar($value) ? (string) $value : json_encode($value);
    }


    public function translateWithTableName(){
        $tableName = $this->findTable();
        return __('tables.' . $tableName);
    }
}
