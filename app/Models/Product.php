<?php

namespace App\Models;

use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Product extends Model
{
    protected $table = 'products';

    const PRODUCT_TYPES = [
        0 => '二手書',
        1 => '講義',
        2 => '筆記',
    ];

    const COURSE_TYPES = [
        1 => '專業科目',
        2 => '共同科目',
        3 => '通識課程',
        4 => '語言相關',
        5 => '其他'
    ];

    protected $fillable = [
        'name', 
        'type',
        'course_type',
        'content', 
        'price', 
        'image', 
        'seller_id', 
        'isbn', 
        'author', 
        'is_stock', 
        'comment_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function tags()
    {
        return $this->hasMany(ProductTag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    public function visits()
    {
        return visits($this);
    }

    public function orderitem(){
        return $this->hasOne(OrderItem::class);
    }
    
    public function favorited(){

        return $this->belongsToMany(User::class, 'favorites', 'product_id' , 'user_id')->withPivot('user_id')->wherePivot('user_id', Auth::id());
    }

    public function carted(){

        return $this->belongsToMany(User::class, 'cart_items', 'product_id' , 'user_id')->withPivot('user_id')->wherePivot('user_id', Auth::id());
    }

    public function link($params  = [])
    {
        return route('products.show', array_merge([$this->id], $params));
    }

    public function updateCommentCount()
    {
        $this->comment_count = $this->comments->count();
        $this->save();
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function($product) {
             
            foreach($product->images as $image){

                if(file_exists(public_path($image->path))){
                    unlink(public_path($image->path));
                        $image->delete();
                }else{
                     dd('image does not exists.');
                }

             }

             $product->tags()->delete();
        });
    }

}
