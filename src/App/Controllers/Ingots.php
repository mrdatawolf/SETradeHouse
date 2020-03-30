<?php namespace Controllers;

use Interfaces\Crud;
use Models\Ingots as DataSource;

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
        $ingot->ore_required    = $data->oreRequired;
        $ingot->base_ore        = $data->baseOre;
        $ingot->keen_crap_fix   = $data->keenCrapFix;
        $ingot->save();

        return $ingot->id;
    }

}