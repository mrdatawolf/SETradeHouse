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

        $this->gatherData();
        $this->gatherBaseOreData();
        $this->setBaseValue();
        $this->oreClass     = new Ores($this->oreId);
        $this->storeAdjustedValue       = (empty($this->baseValue)) ? 0 : $this->baseValue/$this->keenCrapFix;
        $this->scarcityAdjustment = ($this->totalPlanets*10)+($this->totalAsteroids*5);
        $this->scarcityAdjustedValue = $this->storeAdjustedValue*(2-($this->scarcityAdjustment/$this->totalServers));
    }
    
    private function gatherBaseOreData() {
        $this->oreData = $this->find('ores', $this->oreId);
    }

    private function gatherData() {
        $this->data     = $this->find($this->table, $this->id);
        $this->oreId    = $this->data->base_ore;
        $this->title    = $this->data->title;
    }

    private function setBaseValue() {

        $this->baseValue =$this->data->oreRequired*$this->oreClass->getStoreAdjustedValue();
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
}