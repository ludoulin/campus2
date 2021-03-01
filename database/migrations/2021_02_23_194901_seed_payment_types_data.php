<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SeedPaymentTypesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $payment_types = [

            ['name'  => '面交時付費'],
            
            ['name'  => 'LinePay支付'],

            ['name'  => '街口支付'],


    ];

    DB::table('payment_types')->insert($payment_types);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('payment_types')->truncate();
    }
}
