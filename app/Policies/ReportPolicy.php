<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function verification(User $user)
    {
        return $user->role === 'Admin' || $user->role === 'Developer';
    }
}
