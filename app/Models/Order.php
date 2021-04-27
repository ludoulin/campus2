<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';


    protected $dates = ['deleted_at'];


    const Status = [
        0 => '待賣家確認',
        1 => '賣家已確認',
        2 => '交貨完成',
        3 => '取消訂單',
        4 => '申請取消訂單中',
        5 => '拒絕取消訂單',
    ];


    const PaymentStatus = [
        0 => '尚未付款',
        1 => '已付款',
        2 => '已退款',
        3 => '退款中',
        4 => '退款失敗'
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

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function($order) {

    //          $order->items()->delete();
    //          $order->line_pay_record()->delete();
             
    //     });
    // }
}
