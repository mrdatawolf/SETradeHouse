<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonAmmos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.ammo (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (1, '5.56x45mm NATO magazine', 'MyObjectBuilder_AmmoMagazine/NATO_5p56x45mm', 0, 0, 0.8, 0.15, 0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0.45, 0.2)");
        \DB::insert("insert into main.ammo (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (2, '25x184mm NATO ammo container', 'MyObjectBuilder_AmmoMagazine/NATO_25x184mm', 0, 0, 40, 3, 5, 0, 0, 0, 0, 0, 0, 0, 0, 35, 16)");
        \DB::insert("insert into main.ammo (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (3, '200mm missile container', 'MyObjectBuilder_AmmoMagazine/Missile200mm', 0, 0, 55, 1.2, 7, 0.04, 0.2, 0, 0, 0.1, 0, 0, 0, 45, 60)");

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
