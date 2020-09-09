<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMAgicNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magic_numbers', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id');
            $table->decimal('module_base_efficiency');
            $table->decimal('base_multiplier_for_buy_vs_sell');
            $table->decimal('base_refinery_kwh');
            $table->decimal('base_refinery_speed');
            $table->decimal('base_drill_per_kw_hour');
            $table->decimal('markup_for_each_leg');
            $table->decimal('markup_total_change');
            $table->decimal('base_weight_for_world_stock');
            $table->decimal('weight_for_other_world_stock');
            $table->decimal('distance_weight');
            $table->decimal('cost_kw_hour');
            $table->decimal('base_labor_per_hour');
            $table->decimal('local_store_weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worlds');
    }
}
