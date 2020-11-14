<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingots', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('se_name');
            $table->double('keen_crap_fix');
        });
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (1, 'cobalt', 'MyObjectBuilder_Ingot/Cobalt', 1.463463463)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (2, 'nickel', 'MyObjectBuilder_Ingot/Nickel', 1.168)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (3, 'iron', 'MyObjectBuilder_Ingot/Iron', 1.0139860139)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (4, 'platinum', 'MyObjectBuilder_Ingot/Platinum', 1.4620875)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (5, 'uranium', 'MyObjectBuilder_Ingot/Uranium', 1.53646)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (6, 'magnesium', 'MyObjectBuilder_Ingot/Magnesium', 1.1351322978)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (7, 'silver', 'MyObjectBuilder_Ingot/Silver', 1.2309999999)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (8, 'silicon', 'MyObjectBuilder_Ingot/Silicon', 1.153846154)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (9, 'gold', 'MyObjectBuilder_Ingot/Gold', 1.11215)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (10, 'gravel', 'MyObjectBuilder_Ingot/Stone', 1)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (11, 'ice', 'fillme', 1)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (12, 'scrap', 'MyObjectBuilder_Ingot/Scrap', 1)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (13, 'naquadah', 'MyObjectBuilder_Ingot/Naquadah', 1.53646)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (14, 'trinium', 'MyObjectBuilder_Ingot/Trinium', 1.53646)");
        \DB::insert("insert into main.ingots (id, title, se_name, keen_crap_fix) values (15, 'neutronium', 'MyObjectBuilder_Ingot/Neutronium', 1.53646)");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingots');
    }
}
