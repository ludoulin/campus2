<?php
 
namespace App\Services\LineBot;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LineBotService
{
  public function __construct()
    {
        //
    }

  public function getProduct($message){

    $products = Product::where('name','like','%'.$message.'%')->with('images')->get();

    if($products->count()===0){

      $reply = "無結果";

      $messageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($reply);

      return $messageBuilder;

    }else{

      $CarouselColumnTemplateBuilders = array();

      foreach($products as $product){
          
          $action = [ new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("查看詳細", route("products.show",$product->id))];

          $CarouselColumnTemplateBuilder =  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder($product->name, $product->price, "https://picsum.photos/200/300", $action, "#FFFFFF");

          array_push($CarouselColumnTemplateBuilders, $CarouselColumnTemplateBuilder); 

      }
          $CarouselTemplateBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($CarouselColumnTemplateBuilders,"rectangle", "cover");

          $messageBuilder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('test', $CarouselTemplateBuilder);

         return $messageBuilder;
    }
  }
  public function getOrder($message){

    if(strpos($message,'ORD')!==false){ 

      $order = Order::where('order_number', $message)->get();

      Log::info($order);

       $result = count($order) === 0 ? "查無這筆訂單料" : "您要查詢的此筆訂單目前狀態是:".Order::Status[$order[0]->status];
     
     }else{

       $result = "你輸入的訂單格式錯誤";
     }

     return $result;

  }
  public function SaveBotReply($user_id, $time, $text){

      if (Cache::has($user_id)) {                      
        $replys = Cache::get($user_id); 
        $replys[] = $text;
        Cache::put($user_id, $replys, $time);
      }else{
        $reply[]= $text;
        Cache::put($user_id, $reply, $time);
      }

    return ;
  }  
}