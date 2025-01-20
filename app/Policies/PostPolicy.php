<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */

    public function update(User $user, Post $post)
    {
        return $user->id === $post->employee_id || $user->role === 'Admin' || $user->role === 'Developer';
    }
}
