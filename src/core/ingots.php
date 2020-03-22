<?php namespace Core;

use DB\dbClass;

/**
 * Class ingots
 * @package Core
 */
class Ingots extends dbClass
{
    public $id;
    protected $data;
    protected $cluster;
    protected $oreId;
    protected $oreData;
    protected $storeAdjustedValue;
    protected $scarcityAdjustment;
    protected $scarcityAdjustedValue;
    protected $keenCrapFix;

    private $oreClass;
    private $baseValue;
    private $title;

    private $table = 'ingots';

    public function __construct($id)
    {
        parent::__construct();
        $this->id      = $id;
        $this->cluster = new Clusters(2);

        $this->gatherData();
        $this->gatherBaseOreData();
        $this->setBaseValue();
        $this->oreClass                 = $this->cluster->getOre($this->oreId);
        $this->storeAdjustedValue       = (empty($this->baseValue) || empty($this->keenCrapFix)) ? 0 : $this->baseValue/$this->keenCrapFix;
        $this->scarcityAdjustment       = ($this->cluster->totalPlanets*10)+($this->cluster->totalAsteroids*5);
        $this->scarcityAdjustedValue    = $this->storeAdjustedValue*(2-($this->scarcityAdjustment/$this->cluster->totalServers));
    }
    
    private function gatherBaseOreData() {
        $this->oreData = $this->find('ores', $this->oreId);
    }

    private function gatherData() {
        $this->data         = $this->find($this->table, $this->id);
        $this->oreId        = $this->data->base_ore;
        $this->title        = $this->data->title;
        $this->keenCrapFix  = $this->data->keen_crap_fix;
    }

    private function setBaseValue() {
        $this->baseValue =$this->data->ore_required*$this->oreClass->getStoreAdjustedValue();
    }

    public function getName() {
        return $this->title;
    }
    
    public function getEfficiencyPerSecond() {
        $derivedEfficiency  = $this->magicData->base_multiplier_for_buy_vs_sell*$this->oreClass->getBaseConversionEfficiency();
        $time               = ($this->magicData->base_labor_per_hour/$this->oreClass->getBaseProcessingTimePerOre());
        
        return $derivedEfficiency*$time;
    }
    
    public function getBaseValue() {
        return $this->baseValue;
    }
    
    public function getStoreAdjustedMinimum() {
        return $this->baseValue*$this->data->keen_crap_fix;
    }

    public function getScarcityAdjustedValue() {
        return $this->scarcityAdjustedValue;
    }

    public function getKeenCrapFix() {
        return $this->keenCrapFix;
    }

    public function getBaseValueWithEfficiency($modules) {
        return $this->oreClass->getOreRequiredPerIngot($modules)*$this->oreClass->getScarcityAdjustedValue();
    }
}