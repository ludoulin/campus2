<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\ProductReplied;

class CommentObserver
{
    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored

    public function created(Comment $comment)
    {
        
        $comment->product->updateCommentCount();

        // \Debugbar::info($comment->product->user);

        // $comment->product->user->notify(new ProductReplied($comment));

        $comment->product->user->notify(new ProductReplied($comment));

    }

    // public function saved(Comment $comment){

    //     \Debugbar::info($comment->product->user->notify(new ProductReplied($comment)));
    // }

    public function deleted(Comment $comment)
    {
        $comment->product->updateCommentCount();
    }


}
