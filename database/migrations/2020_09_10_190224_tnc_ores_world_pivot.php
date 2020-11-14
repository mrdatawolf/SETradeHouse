<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Ores;

class TncOresWorldPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        for($i=13;$i<=16;$i++) {
            for($j=1;$j<=3;$j++) {
                $ores = new Ores();
                $ore = $ores->find($i);
                $ore->worlds()->attach($j);
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
        for($i=13;$i<=16;$i++) {
            for($j=1;$j<=3;$j++) {
                $ores = new Ores();
                $ore = $ores->find($i);
                $ore->worlds()->detach($j);
            }
        }
    }
}
