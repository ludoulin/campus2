<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PagesController extends Controller
{
    
    public function root()
    {
        $products = Product::with('user')->paginate(10);
        return view('pages.root',compact('products'));

    }
}
