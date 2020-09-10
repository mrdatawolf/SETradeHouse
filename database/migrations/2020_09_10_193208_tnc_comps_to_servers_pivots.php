<?php

use Illuminate\Database\Migrations\Migration;
use App\Components;

class TncCompsToServersPivots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $comps = new Components();
        foreach($comps->all() as $comp) {
            $comp->servers()->attach(1);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $comps = new Components();
        foreach($comps->all() as $comp) {
            $comp->servers()->detach(1);
        }
    }
}
