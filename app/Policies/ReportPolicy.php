<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    /**
     * Create a new policy instance.
     */
    public function verification(User $user)
    {
        return $user->role === 'Admin';
    }
}
