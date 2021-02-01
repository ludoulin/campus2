<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
    // 緩存相關宣告
    protected $hash_prefix = 'campus_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
       
        // 獲取今日Redis的命名，例：campus_last_actived_at_2020-12-29
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名稱，例：user_1
        $field = $this->getHashField();

        // dd(Redis::hGetAll($hash));

        // 當前時間，例：2020-12-29 08:35:15
        $now = Carbon::now()->toDateTimeString();

        // 數據存入Redis ，字段已存在會被更新
        Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt()
    {
        // 獲取昨日Redis的命名，例：campus_last_actived_at_2020-12-28
        $hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

        // 從 Redis 中獲取所有表裡的數據
        $dates = Redis::hGetAll($hash);

        // 遍歷，並同步到資料庫中
        foreach ($dates as $user_id => $actived_at) {
            // 會將 user_1 變成 1
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有當使用者存在時才更新到資料庫中
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        // 以資料庫為中心的暫存，如果已同步，即可刪除
        Redis::del($hash);
    }

    public function getLastActivedAtAttribute($value)
    {
        // 獲取今日 Redis 表的命名，例：campus_last_actived_at_2020-12-29
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名稱，例：user_1
        $field = $this->getHashField();

        // 三元運算符，優先選擇 Redis 的數據，否則使用資料庫中的數據
        $datetime = Redis::hGet($hash, $field) ? : $value;

        // 如果存在的話，返回時間對應的 Carbon 實例
        if ($datetime) {
            return new Carbon($datetime);
        } else {
        // 否則使用使用者的註冊時間
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        // Redis 表的命名，例：campus_last_actived_at_2020-12-29
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名稱，例：user_1
        return $this->field_prefix . $this->id;
    }

}
