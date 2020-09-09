<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ores', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('se_name');
            $table->decimal('base_processing_time_per_ore');
            $table->decimal('base_conversion_efficiency');
            $table->double('keen_crap_fix');
            $table->decimal('module_efficiency_modifier');
            $table->decimal('ore_per_ingot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ores');
    }
}
