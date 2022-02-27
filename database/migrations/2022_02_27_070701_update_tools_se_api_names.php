<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Tools;

class UpdateToolsSeApiNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('tools')) {
            if ( ! Schema::hasColumn('tools', 'api_name')) {
                Schema::table('tools', function (Blueprint $table) {
                    $table->string('api_name')->nullable();
                });
            }
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AngleGrinderItem')->first();
        if($tools) {
            $tools->api_name = 'AngleGrinderItem';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder2Item')->first();
        if($tools) {
            $tools->api_name = 'AngleGrinder2Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder3Item')->first();
        if($tools) {
            $tools->api_name = 'AngleGrinder3Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AngleGrinder4Item')->first();
        if($tools) {
            $tools->api_name = 'AngleGrinder4Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/WelderItem')->first();
        if($tools) {
            $tools->api_name = 'WelderItem';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/Welder2Item')->first();
        if($tools) {
            $tools->api_name = 'Welder2Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/Welder3Item')->first();
        if($tools) {
            $tools->api_name = 'Welder3Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/Welder4Item')->first();
        if($tools) {
            $tools->api_name = 'Welder4Item';
            $tools->save();
        }

        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/HandDrillItem')->first();
        if($tools) {
            $tools->api_name = 'HandDrillItem';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/HandDrill2Item')->first();
        if($tools) {
            $tools->api_name = 'HandDrill2Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/HandDrill3Item')->first();
        if($tools) {
            $tools->api_name = 'HandDrill3Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/HandDrill4Item')->first();
        if($tools) {
            $tools->api_name = 'HandDrill4Item';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/AutomaticRifle')->first();
        if($tools) {
            $tools->api_name = 'AutomaticRifle';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/UltimateAutomaticRifle')->first();
        if($tools) {
            $tools->api_name = 'UltimateAutomaticRifleItem';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/PreciseAutomaticRifle')->first();
        if($tools) {
            $tools->api_name = 'PreciseAutomaticRifle';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalGunObject/RapidFireAutomaticRifle')->first();
        if($tools) {
            $tools->api_name = 'RapidFireAutomaticRifle';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_ConsumableItem/ClangCola')->first();
        if($tools) {
            $tools->api_name = 'ClangCola';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_ConsumableItem/CosmicCoffee')->first();
        if($tools) {
            $tools->api_name = 'CosmicCoffee';
            $tools->save();
        }

        $tools = Tools::where('se_name', 'MyObjectBuilder_ConsumableItem/Medkit')->first();
        if($tools) {
            $tools->api_name = 'Medkit';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_ConsumableItem/Powerkit')->first();
        if($tools) {
            $tools->api_name = 'Powerkit';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_Datapad/Datapad')->first();
        if($tools) {
            $tools->api_name = 'Datapad';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_PhysicalObject/SpaceCredit')->first();
        if($tools) {
            $tools->api_name = 'SpaceCredit';
            $tools->save();
        }
        $tools = Tools::where('se_name', 'MyObjectBuilder_Package/Package')->first();
        if($tools) {
            $tools->api_name = 'Package';
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
        if (Schema::hasTable('tools')) {
            if (Schema::hasColumn('tools', 'api_name')) {
                Schema::table('tools', function (Blueprint $table) {
                    $table->dropColumn('api_name');
                });
            }
        }
    }
}
