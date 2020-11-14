<?php

use Illuminate\Database\Migrations\Migration;
use \App\Models\Worlds;

class TncWorlds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $worlds = new Worlds();
        $worlds->title      = 'Nebulon';
        $worlds->server_id    = 1;
        $worlds->type_id     = 1;
        $worlds->system_stock_weight = 1;
        $worlds->save();

        $worlds = new Worlds();
        $worlds->title      = 'Nebulon-test';
        $worlds->server_id    = 1;
        $worlds->type_id     = 1;
        $worlds->system_stock_weight = 1;
        $worlds->save();

        $worlds = new Worlds();
        $worlds->title      = 'All Alone in the Night';
        $worlds->server_id    = 1;
        $worlds->type_id     = 1;
        $worlds->system_stock_weight = 1;
        $worlds->save();

        $worlds = new Worlds();
        $worlds->title      = 'Midas';
        $worlds->server_id    = 1;
        $worlds->type_id     = 1;
        $worlds->system_stock_weight = 1;
        $worlds->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $worlds             = new Worlds();
        $worlds->where('title','Nebulon')->delete();
        $worlds->where('title','Trinium Plate')->delete();
        $worlds->where('title','Neutronium Crate')->delete();
    }
}
