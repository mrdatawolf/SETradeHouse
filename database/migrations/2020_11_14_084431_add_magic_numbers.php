<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMagicNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.magic_numbers (id, server_id, module_base_efficiency, base_multiplier_for_buy_vs_sell, base_refinery_kwh, base_refinery_speed, base_drill_per_kw_hour, markup_for_each_leg, markup_total_change, base_weight_for_world_stock, weight_for_other_world_stock, distance_weight, cost_kw_hour, base_labor_per_hour, local_store_weight) values (1, 1, 0.8, 0.75, 560, 1.3, 2, 0.03, 1.03, 2, 1, 1.1, 0.0012850929221, 7707.81, 4)");
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
