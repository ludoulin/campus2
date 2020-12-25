<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Product;

class ProductObserver
{
    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored

    public function deleted(Product $product)
    {
        // \DB::table('replies')->where('product_id', $product->id)->delete();
        
        Comment::where('product_id', $product->id)->delete();
    }

}
