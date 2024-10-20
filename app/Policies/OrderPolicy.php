<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->user_type !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->user_type === 'C' && $user->id == $order->customer_id){
            return true;
        }
        if ($user->user_type === 'E' && ($order->status == 'pending' || $order->status == 'paid')){
            return true;
        }
        return $user->user_type === 'A';
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
    public function update(User $user, Order $order): bool
    {
        if ($user->user_type === 'E' && ($order->status == 'pending' || $order->status == 'paid')){
            return true;
        }
        return $user->user_type === 'A';
    }

    public function showReceipt (User $user, Order $order): bool
    {
        if ($user->user_type === 'C' && $user->id === $order->customer_id){
            return true;
        }
        return $user->user_type === 'A';
    }
}
