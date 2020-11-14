<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonBottles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.bottles (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (20, 'Oxygen Bottle', 'MyObjectBuilder_OxygenContainerObject/OxygenBottle', 0, 0, 80, 0, 30, 0, 0, 10, 0, 0, 0, 0, 0, 30, 8)");
        \DB::insert("insert into main.bottles (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (21, 'Hydrogen Bottle', 'MyObjectBuilder_GasContainerObject/HydrogenBottle', 0, 0, 80, 0, 30, 0, 0, 10, 0, 0, 0, 0, 0, 30, 5)");

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
