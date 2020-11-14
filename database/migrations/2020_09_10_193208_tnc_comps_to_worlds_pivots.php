<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Components;

class TncCompsToWorldsPivots extends Migration
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
            for($j=1;$j<=3;$j++) {
                $comp->worlds()->attach($j);
            }
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
            for($j=1;$j<=3;$j++) {
                $comp->worlds()->detach($j);
            }
        }
    }
}
