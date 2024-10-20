<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type === 'A';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->user_type === 'A' && ($model->user_type === 'A' || $model->user_type === 'E')) {
            return true;
        }
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_type === 'A';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function createModel(User $user, User $model): bool
    {
        if ($user->user_type !== 'A') {
            return false;
        }

        return in_array($model->user_type, ['E', 'A']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->user_type === 'C' && $user->id === $model->id) {
            return true;
        }
        if ($user->user_type === 'A' && ($model->user_type === 'A' || $model->user_type === 'E')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->user_type === 'A';
    }
}
