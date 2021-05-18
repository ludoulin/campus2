<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';


    const NEWS_TYPES = [
        1 => '最新消息',
        2 => '學生會公告',
        3 => '維護公告',
        4 => '一般公告',
        5 => '其他'
    ];


    protected $fillable = [
        'name', // 標題
        'type', // 類別(自訂填寫)
        'sticky_flag', // 是否至頂
        'content', // 內容
        'publish_date', // 發布時間
        'start_date', // 顯示日期 - 開始
        'end_date', // 顯示日期 - 結束
    ];

    protected $casts = [
        'sticky_flag' => 'boolean',
        'publish_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
