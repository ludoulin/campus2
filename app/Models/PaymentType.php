<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(User::class,'payment_options','payment_type_id','user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
