<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trends', function (Blueprint $table) {
            $table->id();
            $table->integer('goodTypeId');
            $table->integer('goodId');
            $table->integer('month');
            $table->integer('day');
            $table->integer('hour');
            $table->double('value');
            $table->double('amount');
            $table->double('orderAmount');
            $table->double('offerAmount');
            $table->double('average');
            $table->integer('count');
            $table->integer('orderAmountLatestMinute');
            $table->integer('offerAmountLatestMinute');
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
        Schema::dropIfExists('trends');
    }
}
