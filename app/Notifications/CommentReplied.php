<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Reply;

class CommentReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment_reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->comment_reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','Broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    public function toDatabase($notifiable)
    {

        $product = $this->comment_reply->product;
        $link =  $product->link(['#reply' . $this->comment_reply->comment->id]);

        return [
            'comment_reply_id' => $this->comment_reply->id,
            'content' => $this->comment_reply->reply_content,
            'user_id' => $this->comment_reply->user->id,
            'user_name' => $this->comment_reply->user->name,
            'user_avatar' => $this->comment_reply->user->avatar,
            'product_link' => $link,
            'product_id' => $product->id,
            'product_name' => $product->name,
            // 'comment_content' => $this->comment_reply->comment->content,
        ];
    }


    public function toBroadcast($notifiable)
    {
        $product = $this->comment_reply->product;
        $link =  $product->link(['#reply' . $this->comment_reply->comment->id]);

        return new BroadcastMessage([
            'comment_reply_id' => $this->comment_reply->id,
            'content' => $this->comment_reply->reply_content,
            'user_id' => $this->comment_reply->user->id,
            'user_name' => $this->comment_reply->user->name,
            'user_avatar' => $this->comment_reply->user->avatar,
            'product_link' => $link,
            'product_id' => $product->id,
            'product_name' => $product->name,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
