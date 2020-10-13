<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTncRatioData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ratios = new \App\Models\Ratios;
        $ratios->firstOrCreate([
            'server_id' => 1
        ], [
            'common' => 60,
            'uncommon' => 18,
            'rare' => 4,
            'ultra_rare' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $ratios = new \App\Models\Ratios;
        $ratios->where(
            'server_id', 1)->delete();
    }
}
