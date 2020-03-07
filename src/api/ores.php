<?php namespace API;

use DB\dbClass;

class ores
{
    public $id;
    public $title;
    public $baseCostToGather;
    public $baseProcessingTimePerOre;
    public $baseConversionEfficiency;
    public $maxEfficiencyWithModules;

    public $oreData;

    public function ores() {
        $result = [];
        $dbClass = new dbClass();
        $allOreData = $dbClass->gatherFromTable('ores');
        foreach($allOreData as $data){
            $ore = $this->ore($data['id']);
            $result[$data['id']]=$ore;
        }
        //gather all ores and process thru them building the actual return.
        return json_encode($result);
    }

    public function ore($id) {
        $this->id = $id;
        $oreClass = new \Core\Ores($id);
        return json_encode([$id => [
            'id'                            => $this->id,
            'title'                         => $oreClass->getOreName(),
            'base_cost_to_gather'           => $oreClass->getBaseCostToGatherAnOre(),
            'base_processing_time_per_ore'  => $oreClass->getBaseProcessingTimePerOre(),
            'base_conversion_efficiency'    => $oreClass->getBaseConversionEfficiency(),
            'max_efficiency_with_modules'   => $oreClass->getMaxEfficiencyWithModules()
        ]]);
    }
}