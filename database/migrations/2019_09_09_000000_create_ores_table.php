<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ores', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('se_name');
            $table->decimal('base_processing_time_per_ore');
            $table->decimal('base_conversion_efficiency');
            $table->double('keen_crap_fix');
            $table->decimal('module_efficiency_modifier');
            $table->decimal('ore_per_ingot');
        });

        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (1, 'cobalt', 'MyObjectBuilder_Ore/Cobalt', 4, 0.3, 45.04501198, 0.17150773735, 3.33)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (2, 'nickel', 'MyObjectBuilder_Ore/Nickel', 2, 0.4, 19.99998532, 0.135, 2.5)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (3, 'iron', 'MyObjectBuilder_Ore/Iron', 0.05, 0.7, 34.9650093, 0.045, 1.43)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (4, 'platinum', 'MyObjectBuilder_Ore/Platinum', 4, 0.005, 0.999999266, 10.9375, 200)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (5, 'uranium', 'MyObjectBuilder_Ore/Uranium', 4, 0.007, 2.49999817, -2.90175, 100)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (6, 'magnesium', 'MyObjectBuilder_Ore/Magnesium', 1, 0.007, 0.6999854863, 7.81325, 142.86)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (7, 'silver', 'MyObjectBuilder_Ore/Silver', 1, 0.1, 9.99999266, 0.5395, 10)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (8, 'silicon', 'MyObjectBuilder_Ore/Silicon', 0.6, 0.7, 34.9650093, 0.045, 1.43)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (9, 'gold', 'MyObjectBuilder_Ore/Gold', 0.4, 0.01, 0.999999266, 5.346, 100)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (10, 'stone', 'MyObjectBuilder_Ore/Stone', 0.1, 0.014, 0, 0.0035, 71.43)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (11, 'ice', 'MyObjectBuilder_Ore/Ice', 1, 1.05, 0, 0, 1.19)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (12, 'scrap', 'MyObjectBuilder_Ore/Scrap', 0.05, 0.7, 0, 0.25125, 0.781)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (13, 'space credit', 'MyObjectBuilder_PhysicalObject/SpaceCredit', 1, 1, 1, 1, 1)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (14, 'naquadah', 'MyObjectBuilder_Ore/Naquadah', 4, 0.007, 2.49999817, -2.90175, 100)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (15, 'trinium', 'MyObjectBuilder_Ore/Trinium', 4, 0.007, 2.49999817, -2.90175, 100)");
        \DB::insert("insert into main.ores (id, title, se_name, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) values (16, 'neutronium', 'MyObjectBuilder_Ore/Neutronium', 4, 0.007, 2.49999817, -2.90175, 100)");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ores');
    }
}
