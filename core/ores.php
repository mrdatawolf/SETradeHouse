<?php namespace Core;


use DB\dbClass;
use productionParts\refinery;

/**
 * Class Ores
 * @package Core
 */
class Ores extends dbClass
{
    protected $oreId;
    protected $title;
    protected $oreData;
    protected $serversData;
    protected $ingotsData;
    protected $baseConversionEfficiency;
    protected $baseProcessingTimePerOre;
    
    private $baseValue;
    private $refiningTimePerOre;
    private $orePerIngot;
    private $storeAdjustedValue;
    private $scarcityAdjustment;
    private $scarcityAdjustedValue;
    private $serverCount;
    private $planetCount;
    private $otherCount;
    private $keenCrapFix;
    private $baseCostToGatherAnOre;
    private $scalingModifier;
    
    /**
     * Ores constructor.
     * @param $oreId
     */
    public function __construct($oreId)
    {
        parent::__construct();
        $this->oreId = $oreId;
        $this->gatherOreData($oreId);
        $this->gatherIngotsData();
        $this->gatherRefineryData();
        $this->gatherServersData();
        $this->gatherClusterData();

        $this->setBaseValue();

        $this->storeAdjustedValue       = $this->baseValue/$this->keenCrapFix;
        $this->scarcityAdjustment       = ($this->planetCount*10)+($this->otherCount*5);
        $this->scarcityAdjustedValue    = $this->storeAdjustedValue*(2-($this->scarcityAdjustment/$this->serverCount));
        $this->baseCostToGatherAnOre    = $this->baseValue*$this->scalingModifier;
        $this->baseConversionEfficiency = $this->oreData['base_conversion_efficiency'];
        $this->baseProcessingTimePerOre = $this->oreData['base_processing_time_per_ore'];
    }
    
    /**
     * @param $oreId
     */
    public function gatherOreData($oreId) {
        $this->oreData              = $this->find('ores', $oreId);
        $this->title                = $this->oreData['title'];
        $oresBaseProcessingTime     = $this->oreData['base_processing_time_per_ore'];
        $this->refiningTimePerOre   = $this->baseGameRefinerySpeed/$oresBaseProcessingTime;
        $this->keenCrapFix          = $this->oreData['keen_crap_fix'];
    }
    
    public function gatherIngotsData() {
        $pivot            = $this->findPivots('ingot_ores', 'ore_id', $this->oreId);
        $this->ingotsData   = $this->find('ingots', $pivot['ingot_id']);
        $this->orePerIngot  = $this->ingotsData['oreRequired'];
    }
    
    public function gatherServersData() {
        $pivot               = $this->findPivots('ores_servers','ore_id', $this->oreId);
        $this->serversData      = $this->find('servers', $pivot['server_id']);
        $this->serverCount      = count($this->serversData);
        $this->scalingModifier  = $this->clusterData['scaling_modifier'];
    }

    public function gatherRefineryData() {
        $refinery = new refinery();
        $this->baseGameRefinerySpeed = (is_null($refinery->baseRefinerySpeed)) ? 0 : $refinery->baseRefinerySpeed;
    }

    public function setBaseValue() {
        $refineryCostPerHour        = $this->baseRefineryKilowattPerHourUsage*$this->costPerKilowattHour;
        $drillingCostPerHour        = $this->magicData['drill_kw_hour']*$this->costPerKilowattHour;
        $laborCostPerHour           = $this->magicData['base_labor_per_hour'];
        $perHourCosts               = $refineryCostPerHour+$drillingCostPerHour+$laborCostPerHour;
        $this->baseValue            = $perHourCosts*($this->orePerIngot/$this->foundationOrePerIngot)*$this->scalingModifier;
    }
    
    public function getOreName() {
        return $this->title;
    }
    
    public function getRefineryKiloWattHour() {
        return $this->baseRefineryKilowattPerHourUsage/($this->refiningTimePerOre)/60/60;

    }

	public function getRefineryTime() {
		return  (empty($this->oreData['base_processing_time_per_ore'])) ? null : $this->baseGameRefinerySpeed/$this->refiningTimePerOre;
	}

	public function getOreRequiredPerIngot() {
        return $this->orePerIngot;
    }

    public function getBaseValue() {
        return $this->baseValue;
    }

    public function getStoreAdjustedValue() {
        return $this->storeAdjustedValue;
    }

    public function getScarcityAdjustedValue() {
        return $this->scarcityAdjustedValue;
    }
    
    public function getKeenCrapFix() {
        return $this->keenCrapFix;
    }
    
    public function getBaseCostToGatherAnOre() {
        return $this->baseCostToGatherAnOre;
    }
    
    public function getBaseConversionEfficiency() {
        return $this->baseConversionEfficiency;
    }
    
    public function getBaseProcessingTimePerOre() {
        return$this->baseProcessingTimePerOre;
    }

}