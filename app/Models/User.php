<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use App\Models\SocialUser as SocialUserEloquent;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Notifiable, MustVerifyEmailTrait;

    // const TABLE = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar','is_admin','is_banned',
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
    public function isAuthorOf($model)
    {
        return $this->id == $model->seller_id;
    }
}
