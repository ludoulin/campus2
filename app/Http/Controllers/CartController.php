<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    public function getCart(){
        
        if(Auth::check()){

        $mycarts= Auth::user()->cartitems;

        return view('users.cart',compact('mycarts'));

        }else{

            return view('users.cart');

        }

    }
}
