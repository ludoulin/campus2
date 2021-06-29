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

           $userId = $event['source']['userId'];

           if($event['type'] === 'message'){

            $previous = Cache::has($userId) ? Cache::get($userId) : array();

            switch ($event['message']['type']) {

                case 'text':
                        $message = $event['message']['text'];

                        if($message === "我想要找商品"){

                            $response = $bot->pushMessage($userId, $this->LineBotService->TextReply("請輸入想找的商品"));
                            $this->LineBotService->SaveBotReply($userId, $this->expiresAt, "請輸入想找的商品");
                        }
                        else if($message === "我想知道訂單進度"){

                            $response = $bot->pushMessage($userId, $this->LineBotService->TextReply("請輸入訂單編號"));
                            $this->LineBotService->SaveBotReply($userId, $this->expiresAt, "請輸入訂單編號");
                        }
                        else if($message === "我想要將Line與Campus帳號做綁定"){

                            $response = $bot->createLinkToken($event['source']['userId']);
                            
                            logger($response->getJSONDecodedBody());

                            $result = $response->getJSONDecodedBody();

                            $bot->pushMessage($userId, $this->LineBotService->TextReply(route('login').'?linkToken='.$result["linkToken"]));

                        }
                        else if(count($previous)!== 0 && $previous[count($previous)-1] === "請輸入想找的商品"){

                            $response = $bot->pushMessage($userId, $this->LineBotService->getProduct($message));
                        }
                        else if(count($previous)!== 0 && $previous[count($previous)-1] === "請輸入訂單編號"){
                            $response = $bot->pushMessage($userId, $this->LineBotService->getOrder($message, $userId));
                        }
                        else{

                            $response = $bot->pushMessage($userId, $this->LineBotService->TextReply("請點選menu選單中您要的服務"));
                        }
                            Log::info(Cache::get($event['source']['userId']));

                    break;

                case 'sticker':    

                        $response = $bot->pushMessage($userId, $this->LineBotService->TextReply("請不要使用貼圖"));

                    break;
                }           
                    

                if ($response->isSucceeded()) {
                    logger('reply successfully');
                    break;
                }

            }
            
            if($event['type'] === 'accountLink'){

                $this->LineBotService->ConnectUser($userId, $event['link']['nonce']);

                $bot->linkRichMenu($event['source']['userId'], "richmenu-492805d6d3ee189f23339fc9f6bb870e");

                $response = $bot->pushMessage($userId,  $this->LineBotService->TextReply("綁定成功"));

                if ($response->isSucceeded()) {
                    logger('reply successfully');
                    break;
                }
               
            }

            if($event['type'] === 'postback'){

                if($event['postback']['data']==='action=CheckConnect'){

                    $user = $this->LineBotService->CheckLineConnect($userId);

                    $text = !$user ? "綁定中斷" : "Hello,".$user->name.",你已經綁定成功囉!趕快選擇選單服務吧~";

                    $response = $bot->pushMessage($userId, $this->LineBotService->TextReply($text));

                    if ($response->isSucceeded()) {
                        logger('reply successfully');
                        break;
                    }

                }

                else if(strpos($event['postback']['data'],'confirm')!==false){

                    $str_sec = explode("=", $event['postback']['data']);

                    Log::info($str_sec[1]);

                    $check = $this->LineBotService->UpdateOrder($str_sec[1]);

                    $text = ($check===null) ? "這筆訂單已被取消" : (!$check ? "這筆訂單你已經確認過囉" : "確認完畢,那下一個階段就是和買家面交交貨囉,請不要放鴿子喔");

                    $response = $bot->pushMessage($userId, $this->LineBotService->TextReply($text));

                    if ($response->isSucceeded()) {
                        logger('reply successfully');
                        break;
                    }

                }

                else if(strpos($event['postback']['data'],'apply')!==false){

                    $str_sec = explode("=", $event['postback']['data']);

                    Log::info($str_sec[1]);

                    $check = $this->LineBotService->CancelOrder($str_sec[1]);

                    $text = !$check ? "這筆訂單已經取消囉" : "成功取消";

                    $response = $bot->pushMessage($userId, $this->LineBotService->TextReply($text));

                    if ($response->isSucceeded()) {
                        logger('reply successfully');
                        break;
                    }

                }

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