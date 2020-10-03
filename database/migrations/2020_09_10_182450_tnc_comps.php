<?php

use Illuminate\Database\Migrations\Migration;
use \App\Models\Components;

class TncComps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $components = new Components();
        $components->title      = 'Naquadah Component';
        $components->se_name    = 'MyObjectBuilder_Component/Naquadah';
        $components->cobalt     = 1;
        $components->gravel     = 30;
        $components->naquadah   = 45;
        $components->save();

        $components             = new Components();
        $components->title      = 'Trinium Plate';
        $components->se_name    = 'MyObjectBuilder_Component/Trinium';
        $components->iron       = 18;
        $components->nickel     = 21;
        $components->trinium    = 90;
        $components->save();

        $components             = new Components();
        $components->title      = 'Neutronium Crate';
        $components->se_name    = 'MyObjectBuilder_Component/Neutronium';
        $components->platinum   = 30;
        $components->silicon    = 45;
        $components->neutronium = 105;
        $components->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $components             = new Components();
        $components->where('title','Naquadah Component')->delete();
        $components->where('title','Trinium Plate')->delete();
        $components->where('title','Neutronium Crate')->delete();
    }
}
