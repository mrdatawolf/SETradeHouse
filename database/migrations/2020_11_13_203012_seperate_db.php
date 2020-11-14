<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeperateDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('trends');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('inactive_transactions');
        Schema::dropIfExists('user_storage_values');
        Schema::dropIfExists('npc_storage_values');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
