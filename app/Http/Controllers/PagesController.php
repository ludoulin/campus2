<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PagesController extends Controller
{
    
    public function root()
    {
        $products = Product::with('images')->get();
        return view('pages.root',compact('products'));

    }

    public function test(){

        return view('pages.test');
    }
}
