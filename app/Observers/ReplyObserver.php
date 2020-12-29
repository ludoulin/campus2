<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\CommentReplied;
use Auth;

class ReplyObserver
{
    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored

    public function created(Reply $reply)
    {
        
        $reply->product->updateCommentCount();

        \Debugbar::info($reply->product->user);

        // $comment->product->user->notify(new ProductReplied($comment));

        if($reply->comment->user->id === Auth::id()){

            $reply->product->user->notify(new CommentReplied($reply));

        }else{

            $reply->comment->user->notify(new CommentReplied($reply));
        }

    }

    public function deleted(Reply $reply)
    {
        $reply->product->updateCommentCount();
    }

}
