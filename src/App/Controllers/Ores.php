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

    public static function headers() {
        $headers = [];
        $rowArray = Ore::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            if($key === 'base_cost_to_gather') {
                $key = $key . ' (rounded)';
            }
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (Ore::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                if ($key === 'base_cost_to_gather') {
                    $columnValue = sprintf('%f', $columnValue);
                }
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return Ore::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}