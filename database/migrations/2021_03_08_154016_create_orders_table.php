<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('payment_type_id')->unsigned();
            $table->enum('status', ['待賣家確認', '賣家已確認', '訂單已完成', '拒絕'])->default('待賣家確認');
            $table->integer('price_total');
            $table->unsignedInteger('item_count')->default(1);
            $table->boolean('payment_status')->default(0);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->date('face_time');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
