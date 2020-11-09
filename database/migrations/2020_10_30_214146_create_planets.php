<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id');
            $table->integer('world_id');
            $table->string('title');
            $table->decimal('surface_gravity')->nullable();
            $table->integer('atmosphere_height')->nullable();
            $table->integer('breathable_atmosphere_height')->nullable();
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
        Schema::dropIfExists('planets');
    }
}
