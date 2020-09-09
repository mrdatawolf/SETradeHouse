<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOresServersPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ores_servers', function (Blueprint $table) {
            $table->unsignedInteger('ores_id');
            $table->foreign('ores_id')->references('id')->on('ores');
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
        Schema::dropIfExists('ores_servers');
    }
}
