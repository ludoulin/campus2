<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LinePay extends Model
{
    protected $fillable = [
        'channel_id','channel_secret',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
