<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinePayTradeRecord extends Model
{
    protected $fillable = [
        'user_id','order_id','order_number','transaction_id','confirm_transaction_id','web_payment_url','is_payment_reply','is_confirm'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
