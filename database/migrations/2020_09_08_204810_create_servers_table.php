<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('scarcity_id');
            $table->integer('economy_ore_id');
            $table->integer('economy_stone_modifier');
            $table->integer('scaling_modifier');
            $table->integer('economy_ore_value');
            $table->integer('asteroid_scarcity_modifier');
            $table->integer('planet_scarcity_modifier');
            $table->integer('base_modifier');
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
