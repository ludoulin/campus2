<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent;
use App\Services\LineBot\LineBotService;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;
use Carbon\Carbon;

class LineHookController extends Controller
{
    private $channel_access_token;
    private $channel_secret;
    protected $expiresAt;
    /**
     * @var LineBotService
     */
    protected $LineBotService;

    public function __construct(LineBotService $LineBotService)
    {
        $this->LineBotService = $LineBotService;
        $this->channel_access_token = env('LINE_BOT_CHANNEL_ACCESS_TOKEN');
        $this->channel_secret = env('LINE_BOT_CHANNEL_SECRET');
        $this->expiresAt = Carbon::now()->addMinutes(3);
    }
    public function hooks(Request $request){

        $httpClient = new CurlHTTPClient($this->channel_access_token);

        $bot = new LINEBot($httpClient, [
            'channelSecret' => $this->channel_secret
        ]);

        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);

        if(!$signature) {
            return response('SIGNATURE_INVALID', 403);
        }

        $bot->parseEventRequest($request->getContent(), $signature);
    
        $events = $request->events;

        foreach ($events as $event) {
           logger(json_encode($event));
           if($event['type'] != 'message') continue;

            $message = $event['message']['text'];
            $userId = $event['source']['userId'];
            $previous = Cache::has($userId) ? Cache::get($userId) : array();

            // 不是文字訊息的類型先不處理
            if($event['message']['type']!= 'text') continue;

                if($message === "我想要找商品"){

                    $response = $bot->replyText($event['replyToken'], "請輸入想找的商品");
                    $this->LineBotService->SaveBotReply($userId, $this->expiresAt, "請輸入想找的商品");
                }
                else if($message === "我想知道訂單進度"){

                    $response = $bot->replyText($event['replyToken'], "請輸入訂單編號");
                    $this->LineBotService->SaveBotReply($userId, $this->expiresAt, "請輸入訂單編號");
                }
                else if(count($previous)!== 0 && $previous[count($previous)-1] === "請輸入想找的商品"){

                    $response = $bot->replyMessage($event['replyToken'], $this->LineBotService->getProduct($message));
                }
                else if(count($previous)!== 0 && $previous[count($previous)-1] === "請輸入訂單編號"){
                    $response = $bot->replyText($event['replyToken'], $this->LineBotService->getOrder($message));
                }
                else{

                    $response = $bot->replyText($event['replyToken'], "請點選menu選單中您要的服務");
                }
                    Log::info(Cache::get($event['source']['userId']));  

                if ($response->isSucceeded()) {
                    logger('reply successfully');
                    break;
                }
        }
        return response('成功', 200);
    }

}

 // $match = preg_match('/台灣|臺灣|Taiwan|taiwan|韓總/', $message);
            // $f = $bot->getProfile($event['source']['userId']);
            // $profile = $f->getJSONDecodedBody();
            // $response = $bot->replyMessage($event['replyToken'],  $messageBuilder);
            // if(!$match) continue;