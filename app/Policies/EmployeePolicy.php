<?php

namespace App\Policies;

use App\Models\User;

class EmployeePolicy
{
    /**
     * Create a new policy instance.
     */
    public function crud(User $user)
    {
        return $user->role === 'Admin';
    }
}
