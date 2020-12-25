<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Comment $comment)
    {
        return $user->isAuthor_and_isCommentOf($comment);
    }


    public function destroy(User $user, Comment $comment)
    {
        return $user->isAuthor_and_isCommentOf($comment) || $user->isAuthorOf($comment->product);
    }

}
