<?php

namespace App\Policies\Api\Authors;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    private function rule($user, $post): bool{
        return $user->id === $post->user_id;
    }
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }
    /**
     * Determine whether the user can search Private posts
     */
    public function show(User $user, Post $post)
    {
        if ($post->user_id !== $user->id) {
            return $post->status === 'Private'
            ? Response::deny('Post not found!')
            : Response::allow();

        }
        if ($post->user_id === $user->id) {
            return Response::allow();
        }
        
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $this->rule($user, $post);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $this->rule($user, $post);
    }
}
