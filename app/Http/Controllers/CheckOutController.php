<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\Product;
use App\Models\LinePayTradeRecord;
use App\Models\User;
use Auth;

class CheckOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['payment']]);
    }


    public function getCheckOut(Request $request)
    {

          $p_ids = json_decode($request->p_ids, true);

          if(gettype($p_ids)!=="array"){

            return back()->with("danger","不要惡意操作");

          }

          foreach($p_ids as $key => $p_id){

            $product = Product::find($p_id);

            if(!$product){

                return response()->view('errors.404', ['message' => '找不到你要買的商品'], 404);

            }elseif($product->status===0){

                return response()->view('errors.404', ['message' => '很抱歉你要買的商品已下架'], 404);

            }elseif($product->status===2){

                return redirect()->route('cart')->with('waring',"很抱歉您要買的商品已被別人搶先一步下單");

            }elseif($product->status===3){

                return redirect()->route('cart')->with('danger',"很抱歉您要買的商品已售出");
            }

            $users[$key] = $product->user->id;

        }

            if(count($users)>1){

                foreach($users as $id => $user){

                    if(count($users)-1 === $id){

                        break;
                    }    
                    
                    if($users[$id+1] != $users[$id]){

                            return abort(403);
                        } 
                    }
            }

          $products = Product::with('images')->whereIn('id', $p_ids)->get();

          $total = Product::whereIn('id', $p_ids)->sum('price');

          $user = User::findOrFail($users[count($users)-1]);
          
          $t_prd = collect($p_ids);

          $p_typ = $user->payment_types;

        
        return view("checkout.index",['total'=> $total , 'products'=> $products , 't_prd'=> $t_prd, 'p_type'=> $p_typ]);

    }

    public function getCheckOutSession()
    {
        $cart = Session::get('key');

        if($cart){

            $decrypted = Crypt::decrypt($cart);

            // $p_type = json_decode($decrypted[0], true);

            $p_ids = json_decode($decrypted, true);

            if(gettype($p_ids)!=="array"){

                return back()->route('cart')->with("danger","不要惡意操作");
    
              }

            foreach($p_ids as $key => $p_id){

                $product = Product::find($p_id);

                if(!$product){

                    return response()->view('errors.404', ['message' => '找不到你要買的商品'], 404);
    
                }elseif($product->status===0){
    
                    return response()->view('errors.404', ['message' => '抱歉你要買的商品已下架'], 404);
    
                }elseif($product->status===2){
    
                    return redirect()->route('cart')->with('waring',"很抱歉您要買的商品已被別人搶先一步下單");
    
                }elseif($product->status===3){
    
                    return redirect()->route('cart')->with('danger',"很抱歉您要買的商品已售出");
                }

                $users[$key] = $product->user->id;
            }

            if(count($users)>1){

                foreach($users as $id => $user){

                    if(count($users)-1 === $id){

                        break;
                    }    
                    
                    if($users[$id+1] !== $users[$id]){

                            return abort(403);
                        } 
                    }
            }

            $products = Product::with('images')->whereIn('id', $p_ids)->get();

            $total = Product::whereIn('id', $p_ids)->sum('price');

            $user = User::findOrFail($users[count($users)-1]);


            $t_prd = collect($p_ids);

            $p_typ = $user->payment_types;


        }else{

            return abort(403);
        }

        return view("checkout.index", ['total'=> $total , 'products'=> $products , 't_prd'=> $t_prd, 'p_type'=> $p_typ]);

    }

    public function payment(Request $request)
    {
        $id = $request->p_d;

        $product = Product::find($id);

        if(!$product) {

            return response()->view('errors.404', ['message' => '抱歉這個商品已被移除平台'], 404);

        }elseif($product->status===0){

            return response()->view('errors.404', ['message' => '很抱歉你要買的商品已下架'], 404);

        }elseif($product->status===3){

            return redirect()->back()->with('danger',"很抱歉您要買的商品已售出");
        }

        if(!Auth::check()){
 
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                    $id => [
                        "name" => $product->name,
                        "product_id" => $product->id,
                        "seller_id" => $product->user->id,
                        "price" => $product->price,
                        "image" => $product->images[0]->path,
                        "is_stock" => $product->is_stock
                    ]
            ];
            session()->put('cart', $cart);

             return redirect()->route('cart');
        }

        if(isset($cart[$id])) {
           
            return redirect()->route('cart')->with('warning','商品已存在於購物車');

        }else{

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
           "name" => $product->name,
           "product_id" => $product->id,
           "seller_name" => $product->user->name,
           "price" => $product->price,
           "image" => $product->images[0]->path,
           "is_stock" => $product->is_stock
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart');
    }

        }else{

            if( Auth::user()->cartitems()->where("product_id",$product->id)->count()===0){

                    Auth::user()->cartitems()->attach($product->id);

            }

            return redirect()->route('cart');

        }
    }

    public function confirm(Request $request){

        if($request->input('transactionId')){
    
            $LineRecord = LinePayTradeRecord::where('transaction_id',$request->input('transactionId'))->first();

            if(!$LineRecord){

                return response()->view('errors.404', ['message' => '找不到此筆交易紀錄'], 404);;
            }

            $this->authorize('operate', $LineRecord);

            if(!$LineRecord->is_payment_reply){

                $LineRecord->is_payment_reply = true;

                $LineRecord->save();
            }

            $order_id = Crypt::encrypt($LineRecord->order->id);

            $order_number = $LineRecord->order->order_number;

        }else{

            return abort(403);

        }

        return view('checkout.confirm', compact('order_id','order_number'));

    }
}
