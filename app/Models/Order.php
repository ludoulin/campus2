<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    const Statuses = [
        0 => '待賣家確認',
        1 => '賣家已確認',
        2 => '訂單已完成',
        3 => '拒絕',
    ];


    protected $fillable = [
        'order_number', 'user_id', 'status', 'price_total', 'item_count', 'payment_status', 'payment_type_id',
        'first_name', 'last_name', 'phone_number', 'notes','face_time','seller_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function line_pay_record(){
        return $this->hasOne(LinePayTradeRecord::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($order) {

             $order->items()->delete();
             $order->line_pay_record()->delete();
             
        });
    }
}
