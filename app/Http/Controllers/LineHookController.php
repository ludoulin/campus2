<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\Event\MessageEvent;
use App\Services\LineBot\LineBotService;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;

class LineHookController extends Controller
{
    private $channel_access_token;
    private $channel_secret;

    /**
     * @var LineBotService
     */
    protected $LineBotService;

    public function __construct(LineBotService $LineBotService)
    {
        $this->LineBotService = $LineBotService;
        $this->channel_access_token = env('LINE_BOT_CHANNEL_ACCESS_TOKEN');
        $this->channel_secret = env('LINE_BOT_CHANNEL_SECRET');
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

            $messageType = $event['message']['type'];
            $message = $event['message']['text'];

            // 不是文字訊息的類型先不處理
            if($messageType != 'text') continue;

                if($message === "我想要找商品"){

                    $response = $bot->replyText($event['replyToken'], "請輸入想找的商品");

                }

                if($message === "我想知道訂單進度"){

                    $response = $bot->replyText($event['replyToken'], "請輸入訂單編號");

                }

                $response = $bot->replyMessage($event['replyToken'], $this->LineBotService->getProduct($message));

            if ($response->isSucceeded()) {
                logger('reply successfully');
                return;
            }
        }
        return response('anchor', 200);
    }
}

 // $match = preg_match('/台灣|臺灣|Taiwan|taiwan|韓總/', $message);
            // $f = $bot->getProfile($event['source']['userId']);
            // $profile = $f->getJSONDecodedBody();
            // $response = $bot->replyMessage($event['replyToken'],  $messageBuilder);
            // if(!$match) continue;