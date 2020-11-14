<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommonTools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (4, 'Automatic Rifle', 'MyObjectBuilder_PhysicalGunObject/AutomaticRifle', 0, 0, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (5, 'Elite Automatic Rifle', 'MyObjectBuilder_PhysicalGunObject/UltimateAutomaticRifle', 0, 0, 3, 0, 1, 4, 0, 0, 0, 0, 0, 0, 0, 3, 6)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (6, 'Elite Grinder', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder4Item', 1, 0, 3, 0, 1, 2, 2, 0, 0, 0, 0, 0, 0, 5, 14)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (7, 'Elite Hand Drill', 'MyObjectBuilder_PhysicalGunObject/HandDrill4Item', 0, 0, 20, 0, 3, 2, 3, 0, 0, 0, 0, 0, 0, 22, 8)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (8, 'Elite Welder', 'MyObjectBuilder_PhysicalGunObject/Welder4Item', 0.2, 0, 5, 0, 1, 2, 0, 0, 0, 0, 0, 0, 0, 5, 120)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (9, 'Enhanced Grinder', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder2Item', 2, 0, 3, 0, 1, 0, 6, 0, 0, 0, 0, 0, 0, 0, 8)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (10, 'Enhanced Hand Drill', 'MyObjectBuilder_PhysicalGunObject/HandDrill2Item', 0, 0, 20, 0, 3, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (11, 'Enhanced Welder', 'MyObjectBuilder_PhysicalGunObject/Welder2Item', 0.2, 0, 5, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (12, 'Grinder', 'MyObjectBuilder_PhysicalGunObject/AngleGrinderItem', 0, 0, 3, 0, 1, 0, 1, 0, 5, 0, 0, 0, 0, 0, 10)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (13, 'Hand Drill', 'MyObjectBuilder_PhysicalGunObject/HandDrillItem', 0, 0, 20, 0, 3, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (14, 'Precise Automatic Rifle', 'MyObjectBuilder_PhysicalGunObject/PreciseAutomaticRifle', 5, 0, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (15, 'Proficient Grinder', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder3Item', 1, 0, 3, 0, 1, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (16, 'Proficient Hand Drill', 'MyObjectBuilder_PhysicalGunObject/HandDrill3Item', 0, 0, 20, 0, 3, 0, 3, 2, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (17, 'Proficient Welder', 'MyObjectBuilder_PhysicalGunObject/Welder3Item', 0.2, 0, 5, 0, 1, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (18, 'Rapid-Fire Automatic Rifle', 'MyObjectBuilder_PhysicalGunObject/RapidFireAutomaticRifle', 0, 0, 3, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (id, title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values (19, 'Welder', 'MyObjectBuilder_PhysicalGunObject/WelderItem', 0, 0, 5, 0, 1, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0)");
        \DB::insert("insert into main.tools (title, se_name, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, naquadah, trinium, neutronium, mass, volume) values ('Package', 'MyObjectBuilder_Package/Package', 0, 0, 5, 0, 1, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0)");
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
