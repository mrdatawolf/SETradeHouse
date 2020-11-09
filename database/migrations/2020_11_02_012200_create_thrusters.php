<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Thrusters;

class CreateThrusters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thrusters', function (Blueprint $table) {
            $table->id();
            $table->string('ship_size');
            $table->string('size');
            $table->string('type');
            $table->integer('newtons');
            $table->integer('power_draw');
            $table->boolean('functions_in_space')->default(true);
            $table->integer('weight');
            $table->timestamps();
        });

        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'small';
        $thruster->type = 'ion';
        $thruster->newtons = 14400;
        $thruster->power_draw = 201000;
        $thruster->functions_in_space = true;
        $thruster->weight = 121;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'large';
        $thruster->type = 'ion';
        $thruster->newtons = 172800;
        $thruster->power_draw = 2400000;
        $thruster->functions_in_space = true;
        $thruster->weight = 721;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'small';
        $thruster->type = 'hydrogen';
        $thruster->newtons = 98400;
        $thruster->power_draw = 170000;
        $thruster->functions_in_space = true;
        $thruster->weight = 334;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'large';
        $thruster->type = 'hydrogen';
        $thruster->newtons = 98400;
        $thruster->power_draw = 800000;
        $thruster->functions_in_space = true;
        $thruster->weight = 1222;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'small';
        $thruster->type = 'atmospheric';
        $thruster->newtons = 96000;
        $thruster->power_draw = 600000;
        $thruster->functions_in_space = true;
        $thruster->weight = 699;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'large';
        $thruster->type = 'atmospheric';
        $thruster->newtons = 576000;
        $thruster->power_draw = 2400000;
        $thruster->functions_in_space = true;
        $thruster->weight = 2948;
        $thruster->save();
//large ship
        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'small';
        $thruster->type = 'ion';
        $thruster->newtons = 345600;
        $thruster->power_draw = 3360000;
        $thruster->functions_in_space = true;
        $thruster->weight = 4380;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'large';
        $thruster->type = 'ion';
        $thruster->newtons = 4320000;
        $thruster->power_draw = 33600000;
        $thruster->functions_in_space = true;
        $thruster->weight = 43200;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'small';
        $thruster->type = 'hydrogen';
        $thruster->newtons = 1080000;
        $thruster->power_draw = 1700000;
        $thruster->functions_in_space = true;
        $thruster->weight = 1420;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'large';
        $thruster->type = 'hydrogen';
        $thruster->newtons = 7200000;
        $thruster->power_draw = 10000000;
        $thruster->functions_in_space = true;
        $thruster->weight = 6940;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'small';
        $thruster->type = 'atmospheric';
        $thruster->newtons = 648000;
        $thruster->power_draw = 2400000;
        $thruster->functions_in_space = true;
        $thruster->weight = 4000;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'large';
        $thruster->type = 'atmospheric';
        $thruster->newtons = 6480000;
        $thruster->power_draw = 16800000;
        $thruster->functions_in_space = true;
        $thruster->weight = 32970;
        $thruster->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thrusters');
    }
}
