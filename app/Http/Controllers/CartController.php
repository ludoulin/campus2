<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    public function getCart(){
        
        if(Auth::check()){

        $mycarts= Auth::user()->cartitems;

        $my= $mycarts->groupBy('seller_id');

        
        return view('users.cart',compact('my'));

        }else{

            $collection = collect(session()->get('cart'));


            $datas= $collection->groupBy("seller_id");

        
            return view('users.cart',compact('mycarts','datas'));

        }

    }
}
