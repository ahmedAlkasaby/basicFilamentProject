<?php
namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ActivityLogTrait{

    public static function bootActivityLogTrait()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->handleUpdateLog();
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });

        static::restored(function ($model) {
            $model->logActivity('restored');
        });

        static::forceDeleted(function ($model) {
            $model->logActivity('forceDeleted');
        });
    }

    protected function handleUpdateLog(): void
    {
        if (! $this->shouldLogActivity()) return;

        $changes = $this->getChanges();
        $original = $this->getOriginal();

        unset($changes['updated_at'], $changes['deleted_at']);


        if (empty($changes)) return;

        $detailedChanges = [];
        foreach ($changes as $key => $newValue) {
            $detailedChanges[$key] = [
                'old' => $original[$key] ?? null,
                'new' => $newValue,
            ];
        }

        if (array_key_exists('active', $changes) && count($changes) === 1) {
            $this->logActivity('activated', $detailedChanges);
        } else {
            $this->logActivity('updated', $detailedChanges);
        }
    }


    protected function shouldLogActivity(): bool
    {
        $user = Auth::user();
        return $user && $user->type == 'admin';
    }


    protected function logActivity(string $action, array $changes = null): void
    {
        
        if (! $this->shouldLogActivity()) return;

        $user = Auth::user();

        ActivityLog::create([
            'user_id'      => $user->id,
            'model_type' => get_class($this),
            'model_id'   => $this->id,
            'action'       => $action,
            'changes'      => $changes ? json_encode($changes) : null,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
        ]);

    }

   

}
