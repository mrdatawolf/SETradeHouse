<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngotsOresPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingots_ores', function (Blueprint $table) {
            $table->unsignedInteger('ingots_id');
            $table->foreign('ingots_id')->references('id')->on('ingots');
            $table->unsignedInteger('ores_id');
            $table->foreign('ores_id')->references('id')->on('ores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingots_ores');
    }
}
