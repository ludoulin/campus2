<?php
 
namespace App\Services\LineBot;

use App\Models\Product;

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
}