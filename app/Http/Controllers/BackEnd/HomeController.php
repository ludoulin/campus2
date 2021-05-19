<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware(['auth','admin']);
    }

    public function landingPage(){

        $counter = [
            "users" => User::count(),
            "products" => Product::count(),
            "sales" => Product::where('status',3)->count(),
            "orders" => Order::withTrashed()->count()
        ];

        return view('backend.home',compact('counter'));
    }
}
