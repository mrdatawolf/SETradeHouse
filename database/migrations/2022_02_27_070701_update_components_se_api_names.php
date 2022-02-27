<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Components;

class UpdateComponentsSeApiNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('components')) {
            if ( ! Schema::hasColumn('components', 'api_name')) {
                Schema::table('components', function (Blueprint $table) {
                    $table->string('api_name')->nullable();
                });
            }
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Naquadah')->first();
        if($components) {
            $components->api_name = 'Naquadah';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Trinium')->first();
        if($components) {
            $components->api_name = 'Trinium';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Neutronium')->first();
        if($components) {
            $components->api_name = 'Neutronium';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/ZoneChip')->first();
        if($components) {
            $components->api_name = 'ZoneChip';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/BulletproofGlass')->first();
        if($components) {
            $components->api_name = 'BulletproofGlass';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Canvas')->first();
        if($components) {
            $components->api_name = 'Canvas';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Computer')->first();
        if($components) {
            $components->api_name = 'Computer';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Construction')->first();
        if($components) {
            $components->api_name = 'Construction';
            $components->save();
        }

        $components = Components::where('se_name', 'MyObjectBuilder_Component/Detector')->first();
        if($components) {
            $components->api_name = 'Detector';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Display')->first();
        if($components) {
            $components->api_name = 'Display';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Explosives')->first();
        if($components) {
            $components->api_name = 'Explosives';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Girder')->first();
        if($components) {
            $components->api_name = 'Girder';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/GravityGenerator')->first();
        if($components) {
            $components->api_name = 'GravityGenerator';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/InteriorPlate')->first();
        if($components) {
            $components->api_name = 'InteriorPlate';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/LargeTube')->first();
        if($components) {
            $components->api_name = 'LargeTube';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Medical')->first();
        if($components) {
            $components->api_name = 'Medical';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/MetalGrid')->first();
        if($components) {
            $components->api_name = 'MetalGrid';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Motor')->first();
        if($components) {
            $components->api_name = 'Motor';
            $components->save();
        }

        $components = Components::where('se_name', 'MyObjectBuilder_Component/PowerCell')->first();
        if($components) {
            $components->api_name = 'PowerCell';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/RadioCommunication')->first();
        if($components) {
            $components->api_name = 'RadioCommunication';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Reactor')->first();
        if($components) {
            $components->api_name = 'Reactor';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/SmallTube')->first();
        if($components) {
            $components->api_name = 'SmallTube';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/SolarCell')->first();
        if($components) {
            $components->api_name = 'SolarCell';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/SteelPlate')->first();
        if($components) {
            $components->api_name = 'SteelPlate';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Superconductor')->first();
        if($components) {
            $components->api_name = 'Superconductor';
            $components->save();
        }
        $components = Components::where('se_name', 'MyObjectBuilder_Component/Thrust')->first();
        if($components) {
            $components->api_name = 'Thrust';
            $components->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('components')) {
            if (Schema::hasColumn('components', 'api_name')) {
                Schema::table('components', function (Blueprint $table) {
                    $table->dropColumn('api_name');
                });
            }
        }
    }
}
