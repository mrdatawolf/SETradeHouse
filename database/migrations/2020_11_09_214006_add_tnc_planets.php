<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Planets;

class AddTncPlanets extends Migration
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
        $planet->title = 'Triton';
        $planet->surface_gravity = 1;
        $planet->atmosphere_height = 40;
        $planet->breathable_atmosphere_height = 40;
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
