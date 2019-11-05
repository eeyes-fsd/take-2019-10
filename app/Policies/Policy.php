<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role === 'admin')
        {
            return true;
        }
    }
}
