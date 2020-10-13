<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTncRarityData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ratios = new \App\Models\Rarity;
        $ratios->firstOrCreate([
            'id' => 1
        ], [
            'title' => 'common',
            'minimum_for_first' => 1,
            'type'  => 'common'
        ]);
        $ratios->firstOrCreate([
            'id' => 2
        ], [
            'title' => 'uncommon',
            'minimum_for_first' => 1,
            'type' => 'uncommon'
        ]);
        $ratios->firstOrCreate([
            'id' => 3
        ], [
            'title' => 'gold',
            'minimum_for_first' => 3,
            'type' => 'rare'
        ]);
        $ratios->firstOrCreate([
            'id' => 4
        ], [
            'title' => 'platinum',
            'minimum_for_first' => 3,
            'type' => 'rare'
        ]);
        $ratios->firstOrCreate([
            'id' => 5
        ], [
            'title' => 'uranium',
            'minimum_for_first' => 3,
            'type' => 'rare'
        ]);
        $ratios->firstOrCreate([
            'id' => 6
        ], [
            'title' => 'naquandah',
            'minimum_for_first' => 6,
            'type' => 'ultra-rare'
        ]);
        $ratios->firstOrCreate([
            'id' => 7
        ], [
            'title' => 'neutronium',
            'minimum_for_first' => 6,
            'type' => 'ultra-rare'
        ]);
        $ratios->firstOrCreate([
            'id' => 8
        ], [
            'title' => 'trinium',
            'minimum_for_first' => 6,
            'type' => 'ultra-rare'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rarity');
    }
}
