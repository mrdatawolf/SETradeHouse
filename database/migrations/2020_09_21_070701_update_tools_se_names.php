<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Tools;

class UpdateToolsSeNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/AngleGrinderItem';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder2')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/AngleGrinder2Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder3')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/AngleGrinder3Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/Welder')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/WelderItem';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/Welder2')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/Welder2Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/Welder3')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/Welder3Item';
            $tools->save();
        }

        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/HandDrill')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/HandDrillItem';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/HandDrill2')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/HandDrill2Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/HandDrill3')->first();
        if($tools) {
            $tools->se_name = 'MyObjectBuilder_PhysicalGunObject/HandDrill3Item';
            $tools->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Tools::where('se_name', 'MyObjectBuilder_Component/ZoneChip')->delete();
    }
}
