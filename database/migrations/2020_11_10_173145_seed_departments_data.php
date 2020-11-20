<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedDepartmentsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $departments = [
            [
                'college_id' => 1,
                'name' => '智動科',
            ],
            [
                'college_id' => 1,
                'name' => '機械系',
            ],
            [
                'college_id' => 1,
                'name' => '機電所',
            ],
            [
                'college_id' => 1,
                'name' => '車輛系(所)',
            ],
            [
                'college_id' => 1,
                'name' => '能源冷凍空調系(所)',
            ],
            [
                'college_id' => 1,
                'name' => '製科所',
            ],
            [
                'college_id' => 1,
                'name' => '自動化所',
            ],
            [
                'college_id' => 1,
                'name' => '機電科所',
            ],
            [
                'college_id' => 1,
                'name' => '機電學士班',
            ],
            [
                'college_id' => 1,
                'name' => '機電科技博士外生專班',
            ],
            [
                'college_id' => 1,
                'name' => '機械自動化外生專班',
            ],
            [
                'college_id' => 1,
                'name' => '能源與車輛外生專班',
            ],
            [
                'college_id' => 1,
                'name' => '技優專班',
            ],
            [
                'college_id' => 2,
                'name' => '化工系',
            ],
            [
                'college_id' => 2,
                'name' => '財資系',
            ],
            [
                'college_id' => 2,
                'name' => '土木系',
            ],
            [
                'college_id' => 2,
                'name' => '分子系',
            ],
            [
                'college_id' => 2,
                'name' => '防災所',
            ],
            [
                'college_id' => 2,
                'name' => '高分所',
            ],
            [
                'college_id' => 2,
                'name' => '環境所',
            ],
            [
                'college_id' => 2,
                'name' => '生化所',
            ],
            [
                'college_id' => 2,
                'name' => '化工所',
            ],
            [
                'college_id' => 2,
                'name' => '材料所',
            ],
            [
                'college_id' => 2,
                'name' => '資源所',
            ],
            [
                'college_id' => 2,
                'name' => '工程科技學士班',
            ],
            [
                'college_id' => 2,
                'name' => '能源光電外國學士專班',
            ],
            [
                'college_id' => 3,
                'name' => '工管系(所)',
            ],
            [
                'college_id' => 3,
                'name' => '經管系(所)',
            ],
            [
                'college_id' => 3,
                'name' => '管理所',
            ],
            [
                'college_id' => 3,
                'name' => '管理外國學士專班',
            ],
            [
                'college_id' => 3,
                'name' => '資財系(所)',
            ],
            [
                'college_id' => 3,
                'name' => '國際金融科技專班',
            ],
            [
                'college_id' => 3,
                'name' => 'EMBA',
            ],
            [
                'college_id' => 4,
                'name' => '工設系',
            ],
            [
                'college_id' => 4,
                'name' => '建築系',
            ],
            [
                'college_id' => 4,
                'name' => '建都所',
            ],
            [
                'college_id' => 4,
                'name' => '創新所',
            ],
            [
                'college_id' => 4,
                'name' => '創意設計學士班',
            ],
            [
                'college_id' => 4,
                'name' => '設計所',
            ],
            [
                'college_id' => 4,
                'name' => '互動系(所)',
            ],
            [
                'college_id' => 4,
                'name' => '互動與創新外生專班',
            ],
            [
                'college_id' => 5,
                'name' => '技職所',
            ],
            [
                'college_id' => 5,
                'name' => '英文系(所)',
            ],
            [
                'college_id' => 5,
                'name' => '科技法律學程',
            ],
            [
                'college_id' => 5,
                'name' => '智財所',
            ],
            [
                'college_id' => 5,
                'name' => '文發系(所)',
            ],
            [
                'college_id' => 6,
                'name' => '電機系(所)',
            ],
            [
                'college_id' => 6,
                'name' => '電子系(所)',
            ],
            [
                'college_id' => 6,
                'name' => '資工系(所)',
            ],
            [
                'college_id' => 6,
                'name' => '光電系(所)',
            ],
            [
                'college_id' => 6,
                'name' => '電資學士班',
            ],
            [
                'college_id' => 6,
                'name' => '電資外國學士專班',
            ],
            [
                'college_id' => 6,
                'name' => 'AI雙聯專班',
            ],
        ];

        DB::table('departments')->insert($departments);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('departments')->truncate();
    }
}
