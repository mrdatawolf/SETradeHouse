<?php namespace Core;

use DB\dbClass;

/**
 * Class ingots
 * @package Core
 */
class Ingots extends dbClass
{
    protected $ingotId;
    protected $oreId;
    protected $ingotData;
    protected $oreData;
    
    private $oreClass;
    private $baseValue;
    
    public function __construct($ingotId)
    {
        parent::__construct();
        $this->ingotId      = $ingotId;
        $this->ingotData    =  $this->find('ingots', $this->ingotId);
        $this->oreId        = $this->ingotData['base_ore'];
        $this->oreClass     = new Ores($this->oreId);

        $this->gatherBaseOreData();
    }
    
    public function gatherBaseOreData() {
        $this->oreData = $this->find('ores', $this->oreId);
    }
    public function getIngotName() {
        return $this->title;
    }
    
    public function getEffeciencyPerSecond() {
        $derivedEfficiency  = $this->magicData['base_multiplier_for_buy_vs_sell']*$this->oreClass->getBaseConversionEfficiency();
        $time               = ($this->magicData['base_labor_per_hour']/$this->oreClass->getBaseProcessingTimePerOre());
        
        return $derivedEfficiency*$time;
    }
    
    public function setBaseValue() {
        $this->baseValue = $this->ingotData['oreRequired']*$this->oreClass->getStoreAdjustedValue();
    }
    
    public function getBaseValue() {
        return $this->baseValue;
    }
    
    public function getStoreAdjustedMinimum() {
        return $this->baseValue*$this->ingotData['keen_crap_fix'];
    }
}