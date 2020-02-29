<?php

namespace API;

class ores
{
    public $id;
    public $title;
    public $baseCostToGather;
    public $baseProcessingTimePerOre;
    public $baseConversionEfficiency;
    public $maxEfficiencyWithModules;

    public function ores() {
        //gather all ores and process thru them building the actual return.
        return json_encode([
            'id'                            => $this->id,
            'title'                         => $this->title,
            'base_cost_to_gather'           => $this->baseCostToGather,
            'base_processing_time_per_ore'  => $this->baseProcessingTimePerOre,
            'base_conversion_efficiency'    => $this->baseConversionEfficiency,
            'max_efficiency_with_modules'   => $this->maxEfficiencyWithModules
        ]);
    }

    public function ore($id) {
        //gather just the ore we want to run thru
        return json_encode([
            'id'                            => $this->id,
            'title'                         => $this->title,
            'base_cost_to_gather'           => $this->baseCostToGather,
            'base_processing_time_per_ore'  => $this->baseProcessingTimePerOre,
            'base_conversion_efficiency'    => $this->baseConversionEfficiency,
            'max_efficiency_with_modules'   => $this->maxEfficiencyWithModules
        ]);
    }
}