<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTransactionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('transactions')->dropIfExists('transactions');
        Schema::connection('transactions')->create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->integer('trade_zone_id');
            $table->integer('world_id');
            $table->integer('server_id');
            $table->integer('transaction_type_id');
            $table->integer('good_type_id');
            $table->integer('good_id');
            $table->decimal('value');
            $table->decimal('amount');
            $table->timestamps();
        });
        Schema::connection('transactions')->dropIfExists('inactive_transactions');
        Schema::connection('transactions')->create('inactive_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->integer('trade_zone_id');
            $table->integer('world_id');
            $table->integer('server_id');
            $table->integer('transaction_type_id');
            $table->integer('good_type_id');
            $table->integer('good_id');
            $table->decimal('value');
            $table->decimal('amount');
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
        Schema::connection('transactions')->dropIfExists('inactive_transactions');
    }
}
