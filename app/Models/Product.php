<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'content', 'price', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class,'seller_id');
    }
}
