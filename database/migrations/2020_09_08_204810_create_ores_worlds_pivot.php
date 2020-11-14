<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOresWorldsPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ores_worlds', function (Blueprint $table) {
            $table->unsignedInteger('ores_id');
            $table->foreign('ores_id')->references('id')->on('ores');
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
        Schema::dropIfExists('ores_worlds');
    }
}
