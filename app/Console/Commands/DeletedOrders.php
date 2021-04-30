<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;

class DeletedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '取消逾時的訂單';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('系統取消程序啟動');

        $orders = Order::where('status','=', 0)->where('payment_type_id','=', 1)->where('face_time', '<', Carbon::now())->get();

        foreach($orders as $order){

            $order->status = 5;

            foreach($order->items as $item){

                Product::where('id', $item->product_id)->update(['is_stock'=> 1 ]);
            }
            Log::info('訂單編號:'.$order->order_number.'已被系統自動取消');
            $order->save();;
            $order->delete();
        }
    }
}
