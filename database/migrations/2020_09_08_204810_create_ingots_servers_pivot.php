<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngotsServersPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingots_servers', function (Blueprint $table) {
            $table->unsignedInteger('ingots_id');
            $table->foreign('ingots_id')->references('id')->on('ingots');
            $table->unsignedInteger('servers_id');
            $table->foreign('servers_id')->references('id')->on('servers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingots_servers');
    }
}
