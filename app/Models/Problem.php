<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = 'problems';

    const PROBLEM_TYPES = [
        1 => '一般問題諮詢',
        2 => '頁面異常回報',
        3 => '功能建議或異常回報',
        4 => '商品訂單問題詢問',
        5 => '帳號登入問題',
        6 => '其他'
    ];


    protected $fillable = [
        'title', // 標題
        'type', // 類別(自訂填寫)
        'content', //描述
        'file', // 發布時間
        'user_email', // 信箱
        'order_number', // 訂單編號
    ];
}
