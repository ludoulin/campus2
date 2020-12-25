<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
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

    public function update(User $user, Reply $reply)
    {
        return $user->isAuthor_and_isCommentOf($reply);
    }

    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthor_and_isCommentOf($reply);
    }
}
