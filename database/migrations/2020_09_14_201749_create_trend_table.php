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
            $table->double('amount');
            $table->double('sum');
            $table->integer('count');
            $table->double('average');
            $table->double('orderAmount');
            $table->double('orderSum');
            $table->double('orderCount');
            $table->double('orderAverage');
            $table->integer('orderLatestMinute');
            $table->double('offerAmount');
            $table->double('offerSum');
            $table->double('offerCount');
            $table->double('offerAverage');
            $table->integer('offerLatestMinute');
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
