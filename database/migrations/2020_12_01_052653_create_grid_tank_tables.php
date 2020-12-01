<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGridTankTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grid_tanks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('capacity');
            $table->integer('grid_size');
            $table->integer('gas_type');
            $table->integer('mass');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grid_tanks');
    }
}
