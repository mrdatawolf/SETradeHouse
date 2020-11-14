<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIngotsOresPivotData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (1, 1)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (2, 2)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (3, 3)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (4, 4)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (5, 5)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (6, 6)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (7, 7)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (8, 8)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (9, 9)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (10, 10)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (11, 11)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (12, 12)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (13, 14)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (14, 15)");
        \DB::insert("insert into main.ingots_ores (ingots_id, ores_id) values (15, 16)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
