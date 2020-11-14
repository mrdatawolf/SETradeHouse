<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewStorageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('storage')->dropIfExists('user_storage_values');
        Schema::connection('storage')->create('user_storage_values', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->integer('server_id');
            $table->integer('world_id');
            $table->integer('group_id');
            $table->integer('item_id');
            $table->double('amount');
            $table->timestamps();
        });

        Schema::connection('storage')->dropIfExists('npc_storage_values');
        Schema::connection('storage')->create('npc_storage_values', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->integer('server_id');
            $table->integer('world_id');
            $table->integer('group_id');
            $table->integer('item_id');
            $table->double('amount');
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
        Schema::dropIfExists('user_storage_values');
        Schema::dropIfExists('npc_storage_values');
    }
}
