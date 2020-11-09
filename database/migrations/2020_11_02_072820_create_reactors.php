<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Reactors;

class CreateReactors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactors', function (Blueprint $table) {
            $table->id();
            $table->string('ship_size');
            $table->string('size');
            $table->string('type');
            $table->integer('watts');
            $table->integer('weight')->nullable();
            $table->timestamps();
        });

        $reactor = new Reactors();
        $reactor->ship_size = 'small';
        $reactor->size = 'small';
        $reactor->type = 'normal';
        $reactor->watts = 500000;
        $reactor->save();

        $reactor = new Reactors();
        $reactor->ship_size = 'small';
        $reactor->size = 'large';
        $reactor->type = 'normal';
        $reactor->watts = 14750000;
        $reactor->save();

        $reactor = new Reactors();
        $reactor->ship_size = 'large';
        $reactor->size = 'small';
        $reactor->type = 'normal';
        $reactor->watts = 15000000;
        $reactor->save();

        $reactor = new Reactors();
        $reactor->ship_size = 'large';
        $reactor->size = 'large';
        $reactor->type = 'normal';
        $reactor->watts = 300000000;
        $reactor->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reactors');
    }
}
