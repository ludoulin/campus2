<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class PagesController extends Controller
{
    
    public function root(Product $product)
    {
        $products = Product::where('is_stock',true)->orderBy('id','desc')->with('images','user','favorited')->take(12)->get();
        // dd($products);
        $colleges = College::with('departments')->get();
        $most_views = $product->visits()->top(8);
        return view('pages.root',compact('products','colleges','most_views','product'));

    }

    public function test(){

        return view('pages.test');
    }


    // public function search(Request $request){

    // $query = Request::input('query');
    // $products = Product::where('name','like','%'.$query.'%')->get();
    // return response()->json($products);
    // }
}
