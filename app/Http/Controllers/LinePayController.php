<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\LinePayRequest;
use App\Models\LinePay;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Auth;

class LinePayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(LinepayRequest $request){

        $user = User::findOrFail($request->id);

        if(!$user){

            return abort(404);
        }

        $this->authorize('update', $user);

        if(!$user->linepay){

            $account = new LinePay([
                'channel_id'    =>  Crypt::encrypt($request->channelId),
                'channel_secret'  =>  Crypt::encrypt($request->channelSecret),
            ]);

            $user->linepay()->save($account);
        
        }else{

            $user->linepay->channel_id = Crypt::encrypt($request->channelId);

            $user->linepay->channel_secret = Crypt::encrypt($request->channelSecret);

            $user->linepay->save();

        }

        return response()->json(200);

    }

    public function payment(Request $request){

        $order = Order::find(Crypt::decrypt($request->package));

            if(!$order){
    
                return abort(403);
            }

        $this->authorize('operate', $order);

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
        
        $seller = User::findOrFail($order["seller_id"]);

        /* Array Parameter Data */
        $data = array(
            'productName' => "你買了" . $seller->name . "...等" . $order["item_count"] . "項商品",
            'productImageUrl' => $seller->avatar,
            'amount' => $order["price_total"],
            'currency' => "TWD",
            "orderId" => "$order->id",
            "confirmUrl"=> route("checkout.confirm"),
        );

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

        $order->line_pay_record->transaction_id = $result["info"]["transactionId"];
        $order->line_pay_record->web_payment_url = $result["info"]["paymentUrl"]["web"];

        $order->line_pay_record->save();

        }

        return response()->json($result);

    }

    public function confirm(ConfirmRequest $request){

        $id = Crypt::decrypt($request->confirm);

        $order = Order::find($id);

        if(!$order){

            return abort(403);

        }

        $this->authorize('operate', $order);

        /* API URL */
        $url = 'https://sandbox-api-pay.line.me/v2/payments/'. $order->line_pay_record->transaction_id .'/confirm';

        /* Init cURL res\urce */
        $ch = curl_init($url);

        $ChannelId = "1655822187";

        $ChannelSecret = "50f88278318b440749f6e851c3cf8c44";

        $headers = array(
            "X-LINE-ChannelId:$ChannelId",
            "X-LINE-ChannelSecret:$ChannelSecret",
            "Content-Type:application/json; charset=UTF-8"
        );

        /* Array Parameter Data */

        $data = array(
            'amount' => $order->price_total,
            'currency' => "TWD",
        );;

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

        $order->line_pay_record->confirm_transaction_id = $result["info"]["transactionId"];

        $order->payment_status = true;

        $order->line_pay_record->is_confirm = true;

        $order->line_pay_record->save();

        $order->save();

        }else{

            return back()->with('error', $result["returnCode"]);
        }

        return redirect()->route('users.orders_status', Auth::id())->with('success','交易成功');

        }

        public function refund(Request $request){

            $order = Order::find(Crypt::decrypt($request->package));

            if(!$order){
    
                return abort(403);
            }

            $this->authorize('operate', $order);
    
            /* API URL */
            $url = 'https://sandbox-api-pay.line.me/v2/payments/'. $order->line_pay_record->transaction_id .'/refund';
    
            /* Init cURL res\urce */
            $ch = curl_init($url);
    
            $ChannelId = "1655822187";
    
            $ChannelSecret = "50f88278318b440749f6e851c3cf8c44";
    
            $headers = array(
                "X-LINE-ChannelId:$ChannelId",
                "X-LINE-ChannelSecret:$ChannelSecret",
                "Content-Type:application/json; charset=UTF-8"
            );
    
            /* Array Parameter Data */
    
            // $data = array(
            //     'amount' => $order->price_total,
            // );;
    
            curl_setopt($ch, CURLOPT_POST, true);
    
            /* set return type json */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
            /* set the content type json */
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
            /* pass encoded JSON string to the POST fields */
    
            /* execute request */
            $result = json_decode(curl_exec($ch), true);
    
            /* close cURL resource */
            curl_close($ch);
    
    
            if($result["returnCode"]==="0000"){

                foreach($order->items as $item){

                Product::where('id', $item->product_id)->update(['is_stock'=> 1 ]);

                }
    
             $order->delete();
    
            }
    
            return response()->json($result);


        }
}
