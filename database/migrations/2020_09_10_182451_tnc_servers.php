<?php

use Illuminate\Database\Migrations\Migration;
use \App\Models\Servers;

class TncServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $servers = new Servers();
        $servers->title      = 'The Nebulon Cluster';
        $servers->scarcity_id    = 1;
        $servers->economy_ore_id     = 13;
        $servers->economy_stone_modifier = 0;
        $servers->scaling_modifier = 10;
        $servers->economy_ore_value = 1;
        $servers->asteroid_scarcity_modifier = 1;
        $servers->planet_scarcity_modifier = 1;
        $servers->base_modifier = 1;
        $servers->save();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $servers             = new Servers();
        $servers->where('title','Nebulon')->delete();
        $servers->where('title','Trinium Plate')->delete();
        $servers->where('title','Neutronium Crate')->delete();
    }
}
