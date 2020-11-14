<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoodTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.good_types (id, title) values (1, 'Ore')");
        \DB::insert("insert into main.good_types (id, title) values (2, 'Ingot')");
        \DB::insert("insert into main.good_types (id, title) values (3, 'Component')");
        \DB::insert("insert into main.good_types (id, title) values (4, 'Tool')");
        \DB::insert("insert into main.good_types (id, title) values (5, 'Ammo')");
        \DB::insert("insert into main.good_types (id, title) values (6, 'Bottle')");

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
