<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ComponentsServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components_servers', function (Blueprint $table) {
            $table->unsignedInteger('components_id');
            $table->foreign('components_id')->references('id')->on('components');
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
        Schema::dropIfExists('components_servers');
    }
}
