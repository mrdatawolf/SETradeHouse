<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (5, 'Bulletproof Glass', 'MyObjectBuilder_Component/BulletproofGlass', 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 15, 8)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (6, 'Canvas', 'MyObjectBuilder_Component/Canvas', 0, 0, 2, 0, 0, 0, 35, 0, 0, 0, 0, 0, 0, 15, 8)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (7, 'Computer', 'MyObjectBuilder_Component/Computer', 0, 0, 0.5, 0, 0, 0, 0.2, 0, 0, 0, 0, 0, 0, 0.2, 1)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (8, 'Construction Comp.', 'MyObjectBuilder_Component/Construction', 0, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 8, 2)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (9, 'Detector Comp.', 'MyObjectBuilder_Component/Detector', 0, 0, 5, 0, 15, 0, 0, 0, 0, 0, 0, 0, 0, 5, 0)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (10, 'Display', 'MyObjectBuilder_Component/Display', 0, 0, 1, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 8, 6)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (18, 'Explosives', 'MyObjectBuilder_Component/Explosives', 0, 0, 0, 2, 0, 0, 0.5, 0, 0, 0, 0, 0, 0, 2, 0)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (19, 'Girder', 'MyObjectBuilder_Component/Girder', 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 2)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (20, 'Gravity Comp.', 'MyObjectBuilder_Component/GravityGenerator', 220, 10, 600, 0, 0, 0, 0, 5, 0, 0, 0, 0, 0, 800, 2)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (21, 'Interior Plate', 'MyObjectBuilder_Component/InteriorPlate', 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 200)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (23, 'Large Steel Tube', 'MyObjectBuilder_Component/LargeTube', 0, 0, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 25, 120)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (24, 'Medical Comp.', 'MyObjectBuilder_Component/Medical', 0, 0, 60, 0, 70, 0, 0, 20, 0, 0, 0, 0, 0, 150, 38)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (25, 'Metal Grid', 'MyObjectBuilder_Component/MetalGrid', 3, 0, 12, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 6, 160)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (26, 'Motor', 'MyObjectBuilder_Component/Motor', 0, 0, 20, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 24, 15)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (28, 'Power Cell', 'MyObjectBuilder_Component/PowerCell', 0, 0, 10, 0, 2, 0, 0, 10, 0, 0, 0, 0, 0, 25, 120)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (29, 'Radio-comm Comp.', 'MyObjectBuilder_Component/RadioCommunication', 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 8, 45)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (30, 'Reactor Comp.', 'MyObjectBuilder_Component/Reactor', 0, 0, 15, 0, 0, 0, 0, 5, 20, 0, 0, 0, 0, 25, 140)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (31, 'Small Steel tube', 'MyObjectBuilder_Component/SmallTube', 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 8)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (32, 'Solar Cell', 'MyObjectBuilder_Component/SolarCell', 0, 0, 0, 0, 3, 0, 6, 0, 0, 0, 0, 0, 0, 8, 2)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (34, 'Steel Plate', 'MyObjectBuilder_Component/SteelPlate', 0, 0, 21, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (35, 'Superconductor', 'MyObjectBuilder_Component/Superconductor', 0, 2, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 3)");
        \DB::insert("insert into main.components (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (36, 'Thruster Comp.', 'MyObjectBuilder_Component/Thrust', 10, 1, 30, 0, 0, 0.4, 0, 0, 0, 0, 0, 0, 0, 40, 8)");
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
