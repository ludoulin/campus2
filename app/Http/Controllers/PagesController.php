<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use App\Models\Product;

class PagesController extends Controller
{
    
    public function root()
    {
        $products = Product::orderBy('id','desc')->with('images')->take(12)->get();
        $colleges = College::with('departments')->get();
        return view('pages.root',compact('products','colleges'));

    }

    public function test(){

        return view('pages.test');
    }
}
