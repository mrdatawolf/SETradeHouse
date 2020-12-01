<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PopulateGridTanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::insert("insert into main.grid_tanks (title,capacity,grid_size,gas_type,mass) values ('Hydrogen Tank',15000000,2,1,0)");
        \DB::insert("insert into main.grid_tanks (title,capacity,grid_size,gas_type,mass) values ('Small Hydrogen Tank',1000000,2,1,0)");
        \DB::insert("insert into main.grid_tanks (title,capacity,grid_size,gas_type,mass) values ('Hydrogen Tank',500000,1,1,1581)");
        \DB::insert("insert into main.grid_tanks (title,capacity,grid_size,gas_type,mass) values ('Small Hydrogen Tank',15000,1,1,110)");
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
