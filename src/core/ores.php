<?php namespace Core;


use DB\dbClass;
use Production\Refinery;

/**
 * Class Ores
 * @package Core
 */
class Ores extends dbClass
{
    public $id;
    protected $title;
    protected $data;
    protected $serversData;
    protected $ingotsData;
    protected $baseConversionEfficiency;
    protected $maxConversionEfficiency;
    protected $baseProcessingTimePerOre;
    protected $efficincyModifier;

    private $baseValue;
    private $refiningTimePerOre;
    private $orePerIngot;
    private $storeAdjustedValue;
    private $scarcityAdjustment;
    private $scarcityAdjustedValue;
    private $keenCrapFix;
    private $baseCostToGatherAnOre;
    private $scalingModifier;

    private $table = 'ores';
    
    /**
     * Ores constructor.
     * @param $id
     */
    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
        $this->gatherData();
        $this->gatherIngotsData();
        $this->gatherRefineryData();
        $this->gatherServersData();

        $this->setBaseValue();

        $this->storeAdjustedValue       = (empty($this->baseValue)) ? 0 : $this->baseValue/$this->keenCrapFix;
        $this->scarcityAdjustment       = ($this->planetCount*10)+($this->otherCount*5);
        $this->scarcityAdjustedValue    = $this->storeAdjustedValue*(2-($this->scarcityAdjustment/$this->serverCount));
        $this->baseCostToGatherAnOre    = $this->baseValue*$this->scalingModifier;
        $this->baseConversionEfficiency = $this->data->base_conversion_efficiency;
        $this->maxConversionEfficiency = $this->data->max_efficiency_with_mods;
        $this->baseProcessingTimePerOre = $this->data->base_processing_time_per_ore;
    }

    private function gatherData() {
        $this->data               = $this->find($this->table, $this->id);
        $this->title              = $this->data->title;
        $this->keenCrapFix        = $this->data->keen_crap_fix;
        $this->efficincyModifier  = $this->data->efficiency_modifier;
    }
    
    private function gatherIngotsData() {
        $ingotIds           = $this->findPivots('ore', 'ingot', $this->id);
        $this->ingotsData   = $this->findIn('ingots', $ingotIds);
        foreach($this->ingotsData as $ingotData) {
            $this->orePerIngot[$ingotData->base_ore] = $ingotData->ore_required;
        }
    }

    private function gatherServersData() {
        $serverIds              = $this->findPivots('ore','server', $this->id);
        $clusterServers         = $this->findPivots('cluster','server', $this->clusterId);
        $this->serversData      = $this->findIn('servers', array_intersect($clusterServers, $serverIds));
        $this->serverCount      = count($this->serversData);
        $this->scalingModifier  = $this->clusterData->scaling_modifier;
    }

    private function gatherRefineryData() {
        $refinery = new Refinery();
        $this->baseGameRefinerySpeed = (is_null($refinery->baseRefinerySpeed)) ? 0 : $refinery->baseRefinerySpeed;
    }

    public function setBaseValue() {
        $refineryCostPerHour        = $this->baseRefineryKilowattPerHourUsage*$this->costPerKilowattHour;
        $drillingCostPerHour        = $this->magicData->base_drill_per_kw_hour*$this->costPerKilowattHour;
        $laborCostPerHour           = $this->magicData->base_labor_per_hour;
        $perHourCosts               = $refineryCostPerHour+$drillingCostPerHour+$laborCostPerHour;
        $this->baseValue            = 0;
        $baseValuesArray            = [];
        if(is_array($this->orePerIngot)) {
            foreach ($this->orePerIngot as $ore_required) {
                $baseValuesArray[] = $perHourCosts * ($ore_required / $this->foundationOrePerIngot) * $this->scalingModifier;
            }

            $this->baseValue = array_sum($baseValuesArray);
        }
        $oresBaseProcessingTime   = $this->data->base_processing_time_per_ore;
        $this->refiningTimePerOre = $this->baseGameRefinerySpeed/$oresBaseProcessingTime;
    }

    public function getData() {
        return $this->data;
    }

    public function getName() {
        return $this->title;
    }
    
    public function getRefineryKiloWattHour() {
        $return = 0;
        if(!empty($this->baseRefineryKilowattPerHourUsage) && !empty($this->refiningTimePerOre)) {
            $return = $this->baseRefineryKilowattPerHourUsage / ($this->refiningTimePerOre) / 60 / 60;
        }

        return $return;

    }

	public function getRefineryTime() {
		return  (empty($this->data['base_processing_time_per_ore'])) ? null : $this->baseGameRefinerySpeed/$this->refiningTimePerOre;
	}

	public function getOreRequiredPerIngot($modules = 0) {
        $ingotIds           = $this->findPivots('ore', 'ingot', $this->id);
        if(! empty($ingotIds[0])) {
            if($modules === 0) {
                return $this->orePerIngot[$ingotIds[0]];
            } else {
                return $this->orePerIngot[$ingotIds[0]] * $this->efficincyModifier * $modules;
            }
        }

        return null;
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
        return $this->baseProcessingTimePerOre;
    }

    public function getMaxEfficiencyWithModules() {
        return $this->efficincyModifier*4;
    }

    public function getSystemStock() {
        //has to wait until we have tradezones
        return 1;
    }

    public function getSystemStockGoal() {
        //has to wait until we have tradezones
        return 1;
    }
}