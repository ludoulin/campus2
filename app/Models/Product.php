<?php

namespace App\Models;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'content', 'price', 'image', 'seller_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($product) {
             $product->images()->delete();
        });
    }

}
