<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\College;
use App\Models\ProductTag;

class Department extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'college_id','id',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function tag(){
        return $this->hasOne(ProductTag::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_tags','department_id','product_id');
    }
}
