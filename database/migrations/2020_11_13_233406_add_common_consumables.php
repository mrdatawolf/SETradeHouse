<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonConsumables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.tools (title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values ('Clang Cola', 'MyObjectBuilder_ConsumableItem/ClangCola', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values ('Cosmic Coffee', 'MyObjectBuilder_ConsumableItem/CosmicCoffee', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values ('Medkit', 'MyObjectBuilder_ConsumableItem/Medkit', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values ('Powerkit', 'MyObjectBuilder_ConsumableItem/Powerkit', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values ('Datapad', 'MyObjectBuilder_Datapad/Datapad', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values ('SpaceCredit', 'MyObjectBuilder_PhysicalObject/SpaceCredit', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");

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
