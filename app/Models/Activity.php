<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'name', // 活動名稱
        'year', // 年度
        'content', // 活動內容
        'avatar',//宣傳圖片
        'publish', // 是否發布
        'end_date', // 活動結束日期
    ];

    protected $casts = [
        'end_date' => 'date',
        'publish' => 'boolean'
    ];

}
