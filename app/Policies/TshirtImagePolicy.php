<?php

namespace App\Policies;

use App\Models\TshirtImage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TshirtImagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return $user === null || $user->user_type === 'C';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, TshirtImage $tshirtImage): bool
    {
        if ($user === null) {
            if ($tshirtImage->customer_id !== null) {
                return false;
            }
            return true;
        }

        if ($user->id !== $tshirtImage->customer_id && $tshirtImage->customer_id !== null) {
            return false;
        }

        return $user->user_type === 'C';
    }

    public function viewPersona(User $user, TshirtImage $tshirtImage)
    {
        if ($user->id != $tshirtImage->customer_id || $user->id == 'a') {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->user_type === 'C';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TshirtImage $tshirtImage): bool
    {
        if ($user->user_type === 'C' && $user->id === $tshirtImage->customer_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TshirtImage $tshirtImage): bool
    {
        if ($user->user_type === 'C' && $user->id === $tshirtImage->customer_id) {
            return true;
        }

        return false;
    }

    //ADMIN METHODS

    public function createAdmin(User $user): bool
    {
        return $user->user_type === 'A';
    }

    public function updateAdmin(User $user, TshirtImage $tshirtImage): bool
    {
        if ($user->user_type === 'A' && $tshirtImage->customer_id === null) {
            return true;
        }

        return false;
    }

    public function deleteAdmin(User $user, TshirtImage $tshirtImage): bool
    {
        if ($user->user_type === 'A' && $tshirtImage->customer_id === null) {
            return true;
        }

        return false;
    }
}
