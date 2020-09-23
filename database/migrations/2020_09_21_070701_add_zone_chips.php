<?php

use Illuminate\Database\Migrations\Migration;
use App\Components;

class AddZoneChips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tools = new Components();
        $tools->title      = 'ZoneChip';
        $tools->se_name    = 'MyObjectBuilder_Component/ZoneChip';
        $tools->cobalt     = '0';
        $tools->gold       = '0';
        $tools->iron       = '0';
        $tools->magnesium  = '0';
        $tools->nickel  = '0';
        $tools->platinum  = '0';
        $tools->silicon  = '0';
        $tools->silver  = '0';
        $tools->gravel  = '0';
        $tools->uranium  = '0';
        $tools->naquadah  = '0';
        $tools->trinium  = '0';
        $tools->neutronium  = '0';
        $tools->mass       = '0.25';
        $tools->volume     = '0.2';
        $tools->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Components::where('se_name', 'MyObjectBuilder_Component/ZoneChip')->delete();
    }
}
