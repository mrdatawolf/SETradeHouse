<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ComponentsWorlds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components_worlds', function (Blueprint $table) {
            $table->unsignedInteger('components_id');
            $table->foreign('components_id')->references('id')->on('components');
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
        Schema::dropIfExists('components_worlds');
    }
}
