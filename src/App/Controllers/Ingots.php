<?php namespace Controllers;

use Interfaces\Crud;
use Models\Ingots as DataSource;
use Models\IngotsOres;

/**
 * Class Ingots
 *
 * @package Controllers
 */
class Ingots extends BaseController implements Crud
{
    public $dataSource;

    public function __construct($clusterId)
    {
        $this->clusterId    = $clusterId;
        $this->dataSource   = new DataSource();
    }
    public function create($data) {
        $ingot = $this->dataSource;
        $ingot->title           = $data->title;
        $ingot->keen_crap_fix   = $data->keenCrapFix;
        $ingot->save();

        return $ingot->id;
    }

    public function getOreRequiredPerIngot($ore, $ingotId, $modules) {
        $oreId = $ore->id;
        $moduleEfficiencyModifier  = $ore->module_efficiency_modifier;
        $ingotOresPivot = new IngotsOres();
        ddng($ingotOresPivot->where('ingots_id', $ingotId)->where('ores_id',$oreId)->first()->toArray());
        $modifer = $modules*$moduleEfficiencyModifier;

        return $ingot->ore_required - $modifer;
    }

}