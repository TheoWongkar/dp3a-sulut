<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author->id || $user->role === 'Admin';
    }

    public function destroy(User $user, Post $post): bool
    {
        return $user->id === $post->author->id || $user->role === 'Admin';
    }
}
