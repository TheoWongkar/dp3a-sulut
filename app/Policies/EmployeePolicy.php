<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    /**
     * Create a new policy instance.
     */
    public function show(User $user, Employee $employee)
    {
        return $user->id === $employee->id || $user->role === 'Admin' || $user->role === 'Developer';
    }

    public function create(User $user)
    {
        return $user->role === 'Admin' || $user->role === 'Developer';
    }

    public function updateDelete(User $user)
    {
        return $user->role === 'Admin' || $user->role === 'Developer';
    }
}
