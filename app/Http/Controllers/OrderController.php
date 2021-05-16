<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\CancelReasonRequest;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\LinePayTradeRecord;
use Auth;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     public function create(Request $request)
    {
       
        $p_ids = json_decode($request->p_id, true);

        if(gettype($p_ids)!=="array"){

            return back()->with("danger","不要惡意操作");

          }

        $total = Product::whereIn('id', $p_ids)->sum('price');


        foreach($p_ids as $key => $p_id){

            $product = Product::find($p_id);

            if(!$product){

                return response('抱歉您要買的商品已不存在於平台', 404);

            }elseif($product->status===0){

                return response('抱歉您要買的商品已下架', 404);

            }elseif($product->status===2){

                return response('抱歉您要買的商品已被別人搶先一步下單', 403);

            }elseif($product->status===3){

                return response('抱歉您要買的商品已售出', 404);
            }

            $users[$key] = $product->user->id;

        }


        if(count($users)>1){

            foreach($users as $id => $user){

                if(count($users)-1 === $id){

                    break;
                }    
                
                if($users[$id+1] !== $users[$id]){

                        response('抱歉請不要惡意操作', 403);
                    } 
                }

        }

        $seller_id = $users[count($users)-1];


        // $payment_status = $request->payment === 2 || $request->payment === 3 ? 1 : 0;

        $order = Order::create([
            'order_number'      =>  'ORD-'.strtoupper(uniqid()),
            'user_id'           =>   auth()->user()->id,
            'status'            =>   0,
            'price_total'       =>   $total,
            'item_count'        =>   count($p_ids),
            'payment_status'    =>   0,
            'payment_type_id'   =>   $request->payment,
            'first_name'        =>   $request->first_name,
            'last_name'         =>   $request->last_name,
            'phone_number'      =>   $request->phone_number,
            'face_time'         =>   $request->face_time,
            'notes'             =>   $request->notes,
            'seller_id'         =>   $seller_id,
        ]);


        
        if($order){

            foreach($p_ids as $p_id){

            $product = Product::find($p_id);
   
            $orderItem = new OrderItem([
                'product_id'    =>  $product->id,
                'price'         =>  $product->price,
            ]);

            $order->items()->save($orderItem);

            }  

            Product::whereIn('id', $p_ids)->update(['status'=> 2 ]);

            CartItem::where('user_id', Auth::id())->whereIn('product_id', $p_ids)->delete();


        }else{

            return response('下單過程中發生錯誤', 403);
        }

        if($request->payment==2){

             
            $seller = User::findOrFail($order["seller_id"]);

            $package = array(
                'productName' => "你買了" . $seller->name . "...等" . $order["item_count"] . "項商品",
                'productImageUrl' => $seller->avatar,
                'amount' => $order["price_total"],
                'currency' => "TWD",
                "orderId" => "$order->id",
                "confirmUrl"=> route("checkout.confirm"),
            );


            return $this->linepay($package , $order);

        }else{


        return response()->json(['message' => '面交付費下單成功'], 200);

        }

    }

    public function CancelStatus(Request $request){

        $order = Order::find($request->ord_hash);

        if(!$order){
            
            return abort(403);
        }

        $this->authorize('operate', $order);

        foreach($order->items as $item){

                Product::where('id', $item->product_id)->update(['status'=> 1 ]);
            }
    
        $order->status = 6;

        $order->save();
    
        $order->delete();
       

        return back()->with('success','變更成功');

    }
    
    public function ChangeStatus(Request $request){

        $order = Order::find($request->ord_hash);

        $this->authorize('operate', $order);

        $check = Order::Status;

        if(!$order||!array_key_exists($request->status, $check)){
            
            return abort(403);
        }

        Order::where('id', $order->id)->update(['status'=> $request->status ]);

        if($request->status===2){

            Order::where('id', $order->id)->update(['payment_status'=> 1 ]);

            foreach($order->items as $item){

                Product::where('id', $item->product_id)->update(['status'=> 3 ]);
            }

        }

        if($request->status===3){

            foreach($order->items as $item){

                Product::where('id', $item->product_id)->update(['status'=> 1 ]);
            }

            $order->status = 6;
            
            $order->save();
    
            $order->delete();
        }


        return back()->with('success','變更成功');

    }

    public function apply(Request $request){

        $order = Order::find($request->ord_hash);

        if(!$order){

            return abort(403);

        }

        $this->authorize('operate', $order);

        $order->status = 4;

        $order->cancel_reason = $request->order_cancel;

        $order->save();

        return redirect()->route('users.orders_status',auth()->user()->id)->with('info', '申請訂單取消中');
    }

    public function destroy(Order $order){

        $this->authorize('operate', $order);

        if($order->status!==0){

            return back();
        }

        foreach($order->items as $item){

            Product::where('id', $item->product_id)->update(['status'=> 1 ]);
        }

        $order->status = 3;

        $order->save();

        $order->delete();

		return redirect()->route('users.orders_status',auth()->user()->id)->with('success', '訂單成功取消');

    }



    public function linepay($package , $order){

        /* API URL */
        $url = 'https://sandbox-api-pay.line.me/v2/payments/request';
        
        /* Init cURL resource */
        $ch = curl_init($url);

        $ChannelId = "1655822187";

        $ChannelSecret = "50f88278318b440749f6e851c3cf8c44";

        $headers = array(
            "X-LINE-ChannelId:$ChannelId",
            "X-LINE-ChannelSecret:$ChannelSecret",
            "Content-Type:application/json; charset=UTF-8"
        );
        
        /* Array Parameter Data */
        $data = $package;

        curl_setopt($ch, CURLOPT_POST, true);

          /* set return type json */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
         /* set the content type json */
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        /* pass encoded JSON string to the POST fields */
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        /* execute request */
        $result = json_decode(curl_exec($ch), true);
        
        /* close cURL resource */
        curl_close($ch);

        if($result["returnCode"]==="0000"){

        $LinePayRecord = new LinePayTradeRecord([
            'user_id'   => Auth::id(),
            'order_id'    =>  $order->id,
            'order_number'  =>  $order->order_number,
            'transaction_id' => $result["info"]["transactionId"],
            'web_payment_url' => $result["info"]["paymentUrl"]["web"],
        ]);

        $order->line_pay_record()->save($LinePayRecord);

        }

        return response()->json($result);

    }
}
