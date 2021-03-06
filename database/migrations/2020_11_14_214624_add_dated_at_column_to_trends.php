<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatedAtColumnToTrends extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('trends')->dropIfExists('trends');
        Schema::connection('trends')->create('trends', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_type_id');
            $table->integer('type_id');
            $table->integer('good_id');
            $table->double('amount');
            $table->double('sum');
            $table->integer('count');
            $table->double('average');
            $table->dateTime('dated_at');
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
        Schema::table('trends', function (Blueprint $table) {
            //
        });
    }
}
