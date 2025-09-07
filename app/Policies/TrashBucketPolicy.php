<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TrashBucket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrashBucketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_trash::buckets::trash::bucket');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrashBucket $trashBucket): bool
    {
        return $user->can('{{ View }}');
    }

  
   
    public function restore(User $user, TrashBucket $trashBucket): bool
    {
        return $user->can('restore_trash::buckets::trash::bucket');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_trash::buckets::trash::bucket');
    }

   
}
