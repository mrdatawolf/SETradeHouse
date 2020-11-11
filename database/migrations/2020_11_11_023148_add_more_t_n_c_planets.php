<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Planets;

class AddMoreTNCPlanets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $planet = new Planets();
        $planet->server_id = 1;
        $planet->world_id = 1;
        $planet->title = 'Alien';
        $planet->surface_gravity = 1.1;
        $planet->atmosphere_height = 43;
        $planet->breathable_atmosphere_height = 1;
        $planet->save();
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
