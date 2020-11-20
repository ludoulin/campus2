<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCollegesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $colleges = [

                ['name'  => '機電學院'],
                
                ['name'  => '工程學院'],

                ['name'  => '管理學院'],

                ['name'  => '設計學院'],

                ['name'  => '人文與社會科學學院'],

                ['name'  => '電資學院'],

        ];

        DB::table('colleges')->insert($colleges);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('colleges')->truncate();
    }
}
