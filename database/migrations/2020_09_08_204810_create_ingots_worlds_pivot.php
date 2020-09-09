<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngotsWorldsPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingots_worlds', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ingots_id');
            $table->foreign('ingots_id')->references('id')->on('ingots');
            $table->unsignedInteger('worlds_id');
            $table->foreign('worlds_id')->references('id')->on('worlds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingots_worlds');
    }
}
