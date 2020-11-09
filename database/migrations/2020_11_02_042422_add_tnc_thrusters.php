<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Thrusters;

class AddTncThrusters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'small';
        $thruster->type = 'plasma';
        $thruster->newtons = 14400;
        $thruster->power_draw = 50000;
        $thruster->functions_in_space = true;
        $thruster->weight = 121;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'small';
        $thruster->size = 'large';
        $thruster->type = 'plasma';
        $thruster->newtons = 340000;
        $thruster->power_draw = 340000;
        $thruster->functions_in_space = true;
        $thruster->weight = 721;
        $thruster->save();
//large ship
        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'small';
        $thruster->type = 'plasma';
        $thruster->newtons = 540000;
        $thruster->power_draw = 4500000;
        $thruster->functions_in_space = true;
        $thruster->weight = 4380;
        $thruster->save();

        $thruster = new Thrusters();
        $thruster->ship_size = 'large';
        $thruster->size = 'large';
        $thruster->type = 'plasma';
        $thruster->newtons = 5400000;
        $thruster->power_draw = 40000000;
        $thruster->functions_in_space = true;
        $thruster->weight = 40000000;
        $thruster->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thrusters', function (Blueprint $table) {
            //
        });
    }
}
