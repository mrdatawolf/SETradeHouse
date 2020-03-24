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
    protected $magicData;
    protected $originOre;
    protected $storeAdjustedValue;
    protected $scarcityAdjustment;
    protected $scarcityAdjustedValue;
    protected $moduleEfficiencyModifier;
    protected $keenCrapFix;
    protected $oreRequired;

    private $baseValue;
    private $title;

    private $table = 'ingots';

    public function __construct($id)
    {
        parent::__construct();
        $this->id      = $id;

        $this->gatherData();
        $this->gatherMagicData();
        $this->gatherBaseOreData();
        $this->setBaseValue();

        $this->storeAdjustedValue       = (empty($this->baseValue) || empty($this->keenCrapFix)) ? 0 : $this->baseValue/$this->keenCrapFix;
        $this->scarcityAdjustment       = ($this->cluster->totalPlanets*10)+($this->cluster->totalAsteroids*5);
        $this->scarcityAdjustedValue    = $this->storeAdjustedValue*(2-($this->scarcityAdjustment/$this->cluster->totalServers));
    }


    private function gatherData() {
        $this->data         = $this->find($this->table, $this->id);
        $this->oreId        = $this->data->base_ore;
        $this->title        = $this->data->title;
        $this->keenCrapFix  = $this->data->keen_crap_fix;
        $this->oreRequired  = $this->data->ore_required;
    }


    private function gatherMagicData() {
        $this->magicData = $this->gatherFromTable('magic_numbers');
    }


    private function gatherBaseOreData() {
        $this->oreData = $this->find('ores', $this->originOre);
        $this->moduleEfficiencyModifier = $this->oreData->module_efficiency_modifier;
    }


    private function setBaseValue() {
        $this->baseValue =$this->oreRequired*$this->getStoreAdjustedMinimum();
    }

    public function getName() {
        return $this->title;
    }
    
    public function getEfficiencyPerSecond() {
        $derivedEfficiency  = $this->magicData->base_multiplier_for_buy_vs_sell*$this->oreData->base_conversion_efficiency;
        $time               = ($this->magicData->base_labor_per_hour/$this->oreData->base_processing_time_per_ore);
        
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
        return $this->getOreRequiredPerIngot($modules)*$this->getScarcityAdjustedValue();
    }

    public function getOreRequiredPerIngot($modules = 0) {
            if($modules === 0) {
                return $this->oreRequired;
            } else {
                return $this->oreRequired - ($this->moduleEfficiencyModifier*$modules);
            }
    }
}