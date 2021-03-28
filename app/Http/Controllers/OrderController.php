<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Auth;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function create(OrderRequest $request)
    {
       
        $p_ids = json_decode($request->p_id, true);

        if(gettype($p_ids)!=="array"){

            return back()->with("danger","不要惡意操作");

          }

        $total = Product::whereIn('id', $p_ids)->sum('price');


        foreach($p_ids as $key => $p_id){

            $product = Product::findOrFail($p_id);

            if(!$product){

                return abort(403);

            }elseif(!$product->is_stock){

                return redirect()->route('cart')->with('danger',"很抱歉您要買的商品已遭下架");
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

        $order = Order::create([
            'order_number'      =>  'ORD-'.strtoupper(uniqid()),
            'user_id'           =>   auth()->user()->id,
            'status'            =>   '待賣家確認',
            'price_total'       =>   $total,
            'item_count'        =>   count($p_ids),
            'payment_status'    =>   0,
            'payment_type_id'   =>   $request->payment,
            'first_name'        =>   $request->first_name,
            'last_name'         =>   $request->last_name,
            'phone_number'      =>   $request->phone_number,
            'face_time'         =>   $request->face_time,
            'notes'             =>   $request->notes,
            'seller_id'         =>   $users[count($users)-1],
        ]);


        
        if($order){

            foreach($p_ids as $p_id){

            $product = Product::findOrFail($p_id);
   
            $orderItem = new OrderItem([
                'product_id'    =>  $product->id,
                'price'         =>  $product->price,
            ]);

            $order->items()->save($orderItem);

            }  

            Product::whereIn('id', $p_ids)->update(['is_stock'=> 0 ]);

            CartItem::where('user_id', Auth::id())->whereIn('product_id', $p_ids)->delete();


        }else{

            return redirect()->route('cart')->with('danger',"下單失敗");
        }

        return redirect()->route('users.orders_status',auth()->user()->id)->with('success', '下單成功！');;

    }
    
    public function ChangeStatus(Request $request){

        $order = Order::find($request->ord_hash);

        $this->authorize('operate', $order);

        $check = Order::Statuses;

        if(!$order||!in_array($request->status, $check)){
            
            return abort(403);
        }


        Order::where('id', $order->id)->update(['status'=> $request->status ]);

        if($request->status==="訂單已完成"){

            Order::where('id', $order->id)->update(['payment_status'=> 1 ]);

        }


        return back()->with('success','變更成功');

    }

    public function destroy(Order $order){

        $this->authorize('operate', $order);

        foreach($order->items as $item){

            Product::where('id', $item->product_id)->update(['is_stock'=> 1 ]);
        }

        $order->delete();

		return back()->with('success', '成功取消訂單');

    }
}
