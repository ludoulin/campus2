<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinePayTradeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_pay_trade_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->string('order_number')->unique();
            $table->bigInteger('transaction_id')->unsigned();
            $table->bigInteger('confirm_transaction_id')->unsigned()->nullable();
            $table->string('web_payment_url');
            $table->boolean('is_payment_reply')->default(0);
            $table->boolean('is_confirm')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_pay_trade_records');
    }
}
