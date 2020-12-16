<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('server_info')->create('mods', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id');
            $table->string('message');
            $table->string('mod_type');
            $table->string('mod_number');
            $table->string('description');
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
        Schema::connection('server_info')->dropIfExists('mods');
    }
}
