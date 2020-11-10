<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Thrusters;

class UpdateThrusterValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $thruster = Thrusters::where('ship_size', 'small')->where('size', 'large')->where('type', 'hydrogen')->first();
        $thruster->newtons = 480000;
        $thruster->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $thruster = Thrusters::where('ship_size', 'small')->where('size', 'large')->where('type', 'hydrogen')->first();
        $thruster->newtons = 98400;
        $thruster->save();
    }
}
