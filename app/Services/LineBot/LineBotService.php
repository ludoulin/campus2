<?php
 
namespace App\Services\LineBot;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
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

      $messageBuilder = $this->TextReply("無結果");

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
  public function getOrder($message, $user_id){

    if(strpos($message,'ORD')!==false){ 

      $order = Order::where('order_number', $message)->first();

      Log::info($order);

       $result = !$order || $order->user->line_user_id !== $user_id ? $this->TextReply("查無這筆訂單料") : $this->TextReply("您要查詢的此筆訂單目前狀態是:".Order::Status[$order->status]);
     
     }else{

       $result = $this->TextReply("你輸入的訂單格式錯誤");
     }

     return $result;

  }
  public function TextReply($text){

    $messageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);

    return $messageBuilder;

  }

  public function MultiReply(){

    $messageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

    return $messageBuilder;

  }

  public function StickerReply($package_Id, $sticker_Id){

    $sticker = new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder($package_Id, $sticker_Id);

    return $sticker;

  }

  public function ApplyFlexReply($order){

    $Contents = array();

    foreach($order->items as $item){

        
    $content =  \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                    ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                    ->setContents([
                        \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                        ->setText($item->product->name)
                        ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                        ->setColor('#555555')
                        ->setFlex(3)
                        ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                        \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                        ->setText(strval($item->product->price))
                        ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                        ->setColor('#111111')
                        ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                        ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                    ]);
        

        array_push($Contents, $content); 

    }

    $template =  \LINE\LINEBot\MessageBuilder\FlexMessageBuilder::builder()
                ->setAltText('一筆申請取消訂單')
                ->setContents(
                    \LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder::builder()
                        ->setBody(
                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                ->setContents([\LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                ->setText('買家'.$order->user->name.'-申請取消訂單')
                                                ->setColor('#ff402a')
                                                ->setWeight(\LINE\LINEBot\Constant\Flex\ComponentFontWeight::BOLD)
                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::LG),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                ->setText('訂單編號')
                                                ->setWeight(\LINE\LINEBot\Constant\Flex\ComponentFontWeight::BOLD)
                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::MD)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                ->setText($order->order_number)
                                                ->setWeight(\LINE\LINEBot\Constant\Flex\ComponentFontWeight::BOLD)
                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::MD)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder::builder()
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD)
                                                ->setSpacing(\LINE\LINEBot\Constant\Flex\ComponentSpacing::SM)
                                                ->setContents($Contents),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder::builder()
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD)
                                                ->setSpacing(\LINE\LINEBot\Constant\Flex\ComponentSpacing::SM)
                                                ->setContents([
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("取消理由")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText($order->cancel_reason)
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ])    
                                                ])
                                            ]
                                        )
                                    )
                            ->setFooter(
                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                ->setSpacing(\LINE\LINEBot\Constant\Flex\ComponentSpacing::SM)
                                ->setContents([
                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder::builder()
                                        ->setStyle(\LINE\LINEBot\Constant\Flex\ComponentButtonStyle::LINK)
                                        ->setHeight(\LINE\LINEBot\Constant\Flex\ComponentButtonHeight::SM)
                                        ->setAction(new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("同意取消","apply=".$order->id))
                                        ->setColor('#eeeeee')
                                ])
                                ->setBackgroundColor("#ff402a")
                            )
                        );
                         
    return $template;


  }

  public function FlexReply($order){


    $Contents = array();

    foreach($order->items as $item){

        
    $content =  \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                    ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                    ->setContents([
                        \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                        ->setText($item->product->name)
                        ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                        ->setColor('#555555')
                        ->setFlex(3)
                        ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                        \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                        ->setText(strval($item->product->price))
                        ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                        ->setColor('#111111')
                        ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                        ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                    ]);
        

        array_push($Contents, $content); 

    }

    $template =  \LINE\LINEBot\MessageBuilder\FlexMessageBuilder::builder()
                ->setAltText('一筆新的訂單')
                ->setContents(
                    \LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder::builder()
                        ->setBody(
                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                ->setContents([\LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                ->setText('北科二手書交易平台-訂單資訊')
                                                ->setColor('#4b72ff')
                                                ->setWeight(\LINE\LINEBot\Constant\Flex\ComponentFontWeight::BOLD)
                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                ->setText('訂單編號')
                                                ->setWeight(\LINE\LINEBot\Constant\Flex\ComponentFontWeight::BOLD)
                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::LG)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                ->setText($order->order_number)
                                                ->setWeight(\LINE\LINEBot\Constant\Flex\ComponentFontWeight::BOLD)
                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::MD)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                ->setText('來自買家'.$order->user->name.'的下單')
                                                ->setColor('#aaaaaa')
                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD)
                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder::builder()
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD)
                                                ->setSpacing(\LINE\LINEBot\Constant\Flex\ComponentSpacing::SM)
                                                ->setContents($Contents),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder::builder()
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD)
                                                ->setSpacing(\LINE\LINEBot\Constant\Flex\ComponentSpacing::SM)
                                                ->setContents([
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("訂單人")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText($order->first_name.$order->last_name)
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#111111')
                                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("聯絡電話")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText($order->phone_number)
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#111111')
                                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("面交地點")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("阿水廣場")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#111111')
                                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("面交時間")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText($order->face_time)
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#111111')
                                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),                
                                                ]),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder::builder()
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD),
                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                                ->setMargin(\LINE\LINEBot\Constant\Flex\ComponentMargin::MD)
                                                ->setSpacing(\LINE\LINEBot\Constant\Flex\ComponentSpacing::SM)
                                                ->setContents([
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("項目數量")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText(strval($order->item_count))
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#111111')
                                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("支付方式")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText($order->payment_type->name)
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#111111')
                                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),
                                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                                        ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::HORIZONTAL)
                                                        ->setContents([
                                                            \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText("合計")
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#555555')
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE),
                                                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder::builder()
                                                                ->setText(strval($order->price_total))
                                                                ->setSize(\LINE\LINEBot\Constant\Flex\ComponentFontSize::SM)
                                                                ->setColor('#111111')
                                                                ->setAlign(\LINE\LINEBot\Constant\Flex\ComponentAlign::END)
                                                                ->setPosition(\LINE\LINEBot\Constant\Flex\ComponentPosition::RELATIVE)
                                                        ]),        
                                                ]),
                                            ]
                                        )
                                    )
                            ->setFooter(
                                \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder::builder()
                                ->setLayout(\LINE\LINEBot\Constant\Flex\ComponentLayout::VERTICAL)
                                ->setSpacing(\LINE\LINEBot\Constant\Flex\ComponentSpacing::SM)
                                ->setContents([
                                    \LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder::builder()
                                        ->setStyle(\LINE\LINEBot\Constant\Flex\ComponentButtonStyle::LINK)
                                        ->setHeight(\LINE\LINEBot\Constant\Flex\ComponentButtonHeight::SM)
                                        ->setAction(new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("賣家確認","confirm=".$order->id))
                                        ->setColor('#eeeeee')
                                ])
                                ->setBackgroundColor("#4b72ff")
                            )
                        );
                         
    return $template;

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
  public function UpdateOrder($order_id){

    $check = false;

    $order = Order::find($order_id);

    Log::info($order);

    if(!$order){

      return null;

    }

    if($order->status===0){

      $order->status = 1;
      
      $order->save();

      $check = true;

    }

    return $check;
  }

  public function CancelOrder($order_id){

    $check = false;

    $order = Order::find($order_id);

    if(!$order){

      return false;

    }

    if($order->status===4){

      foreach($order->items as $item){

        Product::where('id', $item->product_id)->update(['status'=> 1 ]);
    }

      $order->status = 6;
      
      $order->save();
    
      $order->delete();

      $check = true;

    }

    return $check;
  }
  
  public function ConnectUser($user_id, $nonce){

    $user = User::where('nonce', $nonce)->first();

    $user->line_user_id = $user_id;

    $user->save();

    return;
  }

  public function CheckLineConnect($user_id){

    $user = User::where('line_user_id', $user_id)->first();

    return $user;
  }
}