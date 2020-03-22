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
    protected $baseProcessingTimePerOre;
    protected $moduleEfficiencyModifier;
    protected $serverCount;
    protected $totalPlanetsOn = 0;
    protected $totalAsteroidsOn = 0;

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
        $this->id = (int) $id;
        $this->gatherData();
        $this->gatherIngotsData();
        $this->gatherRefineryData();
        $this->gatherServersData();

        $this->setBaseCostToGather();
        $this->setBaseValue();
        $this->setTotalPlanetsAsteroidsOn();
        $this->setScarcityAdjustment();

        $this->storeAdjustedValue       = (empty($this->baseValue) || empty($this->keenCrapFix)) ? 0 : $this->baseValue*$this->keenCrapFix;
        $this->scarcityAdjustedValue    = $this->storeAdjustedValue*(2-($this->scarcityAdjustment/($this->totalServers*10)));
        $this->baseConversionEfficiency = $this->data->base_conversion_efficiency;
        $this->baseProcessingTimePerOre = $this->data->base_processing_time_per_ore;
    }

    private function gatherData() {
        $this->data               = $this->find($this->table, $this->id);
        $this->title              = $this->data->title;
        $this->keenCrapFix        = $this->data->keen_crap_fix;
        $this->moduleEfficiencyModifier  = $this->data->module_efficiency_modifier;
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

    private function setBaseValue() {
        //Ore gather and process markup * $this->getBaseCostToGatherOre
        $refineryCostPerHour        = $this->baseRefineryKilowattPerHourUsage*$this->costPerKilowattHour;
        $drillingCostPerHour        = $this->magicData->base_drill_per_kw_hour*$this->costPerKilowattHour;
        $laborCostPerHour           = $this->magicData->base_labor_per_hour;
        $perHourCosts               = $refineryCostPerHour+$drillingCostPerHour+$laborCostPerHour;
        $this->baseValue            = 0;
        if($this->id != 10) {
            $this->baseValue = array_sum($this->orePerIngot) * 2;
        }
        $oresBaseProcessingTime   = $this->data->base_processing_time_per_ore;
        $this->refiningTimePerOre = $this->baseGameRefinerySpeed/$oresBaseProcessingTime;
    }

    private function setBaseCostToGather() {
        $orePerIngot = 0;
        foreach ($this->orePerIngot as $required) {
            $orePerIngot+=(double)$required;
        }
        $baseOrePerIngot    = (double)$this->foundationOrePerIngot;
        $scalingModifier    = (double)$this->clusterData->scaling_modifier;

        $this->baseCostToGatherAnOre = ($orePerIngot/$baseOrePerIngot)*$scalingModifier;
    }

    private function setTotalPlanetsAsteroidsOn() {
        $serversWithOre = $this->findPivots('ore', 'server', $this->id);
        foreach($serversWithOre as $server) {
            if(in_array($server, $this->planetIds)) {
                $this->totalPlanetsOn++;
            } elseif(in_array($server, $this->asteroidIds)) {
                $this->totalAsteroidsOn++;
            }
        }
    }

    private function setScarcityAdjustment() {
        $totalServersWithOre = $this->totalPlanetsOn+$this->totalAsteroidsOn;
        if($totalServersWithOre === $this->totalServers) {
            $this->scarcityAdjustment = $this->totalServers*10;
        } else {
            $this->scarcityAdjustment = ($this->totalPlanetsOn * 10) + ($this->totalAsteroidsOn * 5);
        }
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

                return $this->orePerIngot[$ingotIds[0]] - ($this->moduleEfficiencyModifier*$modules);
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

    public function getScarcityAdjustment() {
        return $this->scarcityAdjustment;
    }
    
    public function getKeenCrapFix() {
        return $this->keenCrapFix;
    }
    
    public function getBaseCostToGatherOre($total = 1) {
        return $this->baseCostToGatherAnOre*$total;
    }
    
    public function getBaseConversionEfficiency() {
        return $this->baseConversionEfficiency;
    }
    
    public function getBaseProcessingTimePerOre() {
        return $this->baseProcessingTimePerOre;
    }

    public function getMaxEfficiencyWithModules($modules = 0) {
        $modifer = $modules*$this->moduleEfficiencyModifier;

        return $this->baseConversionEfficiency + $modifer;
    }

    public function getServerCount() {
        return$this->serverCount;
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