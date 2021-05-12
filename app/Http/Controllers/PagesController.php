<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\College;
use App\Models\Product;

class PagesController extends Controller
{
    
    public function root(Product $product)
    {
        $products = Product::where('is_stock',true)->orderBy('id','desc')->with('images','user','favorited')->take(10)->get();
        $colleges = College::with('departments')->get();
        $activities = Activity::where('publish', true)->orderBy('id','desc')->take(10)->get();
        $most_views = $product->visits()->top(8);

        return view('pages.root',compact('products','colleges','most_views','activities'));
    }

    public function test(){


        return view('pages.test');
    }

    public function activities(Activity $activity){


        return view('pages.activity',compact('activity'));
    }


    // public function search(Request $request){

    // $query = Request::input('query');
    // $products = Product::where('name','like','%'.$query.'%')->get();
    // return response()->json($products);
    // }
}
