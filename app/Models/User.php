<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use App\Models\SocialUser as SocialUserEloquent;
use Auth;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmailTrait;

    //記錄最後登入時間
    use Traits\LastActivedAtHelper;


    use Notifiable {
        notify as protected laravelNotify;
    }

    // use Notifiable;
    // const TABLE = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar','is_admin','is_banned','notification_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_banned'=> 'boolean'

    ];

    public function notify($instance)
    {
        // 如果要通知的人是當前用戶，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有數據庫類型通知才需提醒，直接發送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

    public function RestUnread()
    {
        $this->notification_count = 0;
        $this->save();

    }

    public function socialuser(){
        return $this->hasOne(SocialUserEloquent::class);
    }

    public function isAdmin()
    {
       return $this->is_admin; // this looks for an admin column in your users table
    }
    public function isBanned()
    {
       return $this->is_banned; // this looks for an admin column in your users table
    }
    public function messages(){

        return $this->hasMany(Chat::class);
        
    }
    public function products(){

        return $this->hasMany(Product::class);
        
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function favorites()
    {
    return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')->withTimeStamps();
    }

    public function cartitems()
    {
    return $this->belongsToMany(Product::class, 'cart_items', 'user_id', 'product_id')->withTimeStamps();
    }

    public function payment_types(){

        return $this->belongsToMany(PaymentType::class, 'payment_options', 'user_id' , 'payment_type_id')->withTimeStamps();
    }
    
    public function isAuthorOf($model)
    {
        return $this->id == $model->seller_id;
    }

    public function isAuthor_and_isCommentOf($model)
    {
    return $this->id == $model->user_id;
    }

    // public function receivesBroadcastNotificationOn(){

    //     return 'App.User.'.$this->id;
    // }
}
