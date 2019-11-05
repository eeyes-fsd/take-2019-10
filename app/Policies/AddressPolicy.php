<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Address;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy extends Policy
{
    /**
     * @param User $user
     * @param Address $address
     * @return bool
     */
    public function show(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }

    /**
     * @param User $user
     * @param Address $address
     * @return bool
     */
    public function update(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }

    /**
     * @param User $user
     * @param Address $address
     * @return bool
     */
    public function delete(User $user, Address $address)
    {
        return $user->id === $address->user_id;
    }
}
