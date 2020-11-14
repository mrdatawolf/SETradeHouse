<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Ores;

class AddOresServersPivotData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        for($i=1;$i<=16;$i++) {
            $ores = new Ores();
            $ore = $ores->find($i);
            $ore->servers()->attach(1);
        }
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
