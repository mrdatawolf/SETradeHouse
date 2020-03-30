<?php namespace Controllers;

use Interfaces\Crud;
use Models\Ores as DataSource;

/**
 * Class Ores
 *
 * @package Controllers
 */
class Ores extends BaseController implements Crud
{
    public $dataSource;

    public function __construct($clusterId)
    {
        $this->clusterId    = $clusterId;
        $this->dataSource   = new DataSource();
    }

    public function create($data) {
        $ore = $this->dataSource;
        $ore->title                         = $data->title;
        $ore->base_cost_to_gather           = $data->baseCostToGather;
        $ore->base_processing_time_per_ore  = $data->baseProcessingTimePerOre;
        $ore->base_conversion_efficiency    = $data->baseConversionEfficiency;
        $ore->keen_crap_fix                 = $data->keenCrapFix;
        $ore->module_efficiency_modifier    = $data->moduleEfficiencyModifier;
        $ore->save();


        return $ore->id;
    }
}