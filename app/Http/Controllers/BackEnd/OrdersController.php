<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $orders = Order::with(['user','items'=> function($query){$query->with(["product"=> function($query){$query->with("user");}]);}])->get();

        return view('backend.order.index',compact('orders'));

    }
}
