<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\College;
use App\Models\Product;
use App\Models\News;
use App\Models\Order;
use App\Models\User;


class PagesController extends Controller
{
    
    public function root(Product $product)
    {
        $products = Product::where('is_stock',true)->orderBy('id','desc')->with('images','user','favorited')->take(10)->get();
        $colleges = College::with('departments')->get();
        $activities = Activity::where('publish', true)->orderBy('id','desc')->take(10)->get();
        $most_views = $product->visits()->top(8);
        $newsCollection = News::orderBy('sticky_flag', 'desc')->orderBy('publish_date', 'desc')->where('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->get();

        $counter = [
            "users" => User::count(),
            "products" => Product::count(),
            "sales" => Product::where('status',3)->count(),
            "orders" => Order::count()
        ];

        return view('pages.root',compact('products','colleges','most_views','activities','newsCollection','counter'));
    }

    public function test(){


        return view('pages.test');
    }

    public function activities(Activity $activity){


        return view('pages.activity',compact('activity'));
    }


    public function news(News $news){

        $activities = Activity::where('publish', true)->orderBy('id','desc')->take(10)->get();

        return view('pages.news',compact('news','activities'));
    }


    // public function search(Request $request){

    // $query = Request::input('query');
    // $products = Product::where('name','like','%'.$query.'%')->get();
    // return response()->json($products);
    // }
}
