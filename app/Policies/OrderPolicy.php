<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy extends Policy
{
    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function show(User $user, Order $order)
    {
        return $order->user_id === $user->id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function update(User $user, Order $order)
    {
        return $order->user_id === $user->id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function delete(User $user, Order $order)
    {
        return $order->user_id === $user->id;
    }
}
