<?php namespace Controllers;

use Models\Ores as Ore;

class Ores
{

    public function create($title, $baseCostToGather, $baseProcessingTimePerOre, $baseConversionEfficiency, $keenCrapFix, $moduleEfficiencyModifier) {
        $ore = new Ore();
        $ore->title = $title;
        $ore->base_cost_to_gather = $baseCostToGather;
        $ore->base_processing_time_per_ore = $baseProcessingTimePerOre;
        $ore->base_conversion_efficiency = $baseConversionEfficiency;
        $ore->keen_crap_fix = $keenCrapFix;
        $ore->module_efficiency_modifier = $moduleEfficiencyModifier;
        $ore->save();


        return $ore->id;
    }

    public function read() {
        return Ore::all();
    }

    public function update() {

    }

    public function delete() {

    }

}