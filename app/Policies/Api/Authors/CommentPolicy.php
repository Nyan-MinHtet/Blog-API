<?php

namespace App\Policies\Api\Authors;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): Response
    {
        return $comment->user_id !== Auth::id()
                ? Response::deny()
                : Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): Response
    {
        return $comment->user_id === $user->id
        ? Response::allow()
        : Response::deny() ;
    }

}
