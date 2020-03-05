<?php namespace Core;


use DB\dbClass;
use productionParts\refinery;

class ores extends dbClass
{
    protected $oreId;
    protected $oreData;
    protected $foundationOre;
    protected $magicData;
    protected $serverData;
    protected $ingotData;
    protected $foundationIngotData;

    private $baseGameRefinerySpeed;
    private $baseRefineryKilowattPerHourUsage;
    private $baseValue;
    private $refiningTimePerOre;
    private $costPerKilowattHour;
    private $orePerIngot;
    private $storeAdjustedValue;
    private $scarcityAdjustment;
    private $scarcityAdjustedValue;

    public function __construct($oreId)
    {
        parent::__construct();
        $this->oreId = $oreId;
        $this->gatherOreData($oreId);
        $this->gatherMagicData();
        $this->gatherServerData(1);
        $this->gatherIngotData();
        $this->gatherRefineryData();

        $this->setBaseValue();

        $this->storeAdjustedValue       = $this->baseValue/$this->oreData['keen_crap_fix'];
        $this->scarcityAdjustment       = (SUM(MagicNumbers!$H23:$M23)*10)+(SUM(MagicNumbers!$N23:$Q23)*5));
        $this->scarcityAdjustedValue    = $this->storeAdjustedValue*(2-($this->scarcityAdjustment/$this->serverData['total_systems_count']);
        //$this->scarcityAdjustedValue    = $this->storeAdjustedValue*$this->serverData['total_systems_count']*$this->serverData['planet_scarcity_modifier'];
    }

    public function gatherMagicData() {
        $stmt = $this->dbase->prepare("SELECT * FROM magic_numbers");
        $stmt->execute();
        $this->magicData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->baseRefineryKilowattPerHourUsage = $this->magicData['base_refinery_kwh'];
        $this->costPerKilowattHour = $this->magicData['cost_kw_hour'];
    }

    public function gatherServerData($serverId) {
        $stmt = $this->dbase->prepare("SELECT * FROM servers WHERE id=" . $serverId);
        $stmt->execute();
        $this->serverData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function gatherOreData($oreId) {
        $stmt = $this->dbase->prepare("SELECT * FROM ores WHERE id=" . $oreId);
        $stmt->execute();
        $this->oreData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->dbase->prepare("SELECT * FROM ores WHERE id=4");
        $stmt->execute();
        $this->foundationOre = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $oresBaseProcessingTime = $this->oreData['base_processing_time_per_ore'];
        $this->refiningTimePerOre = $this->baseGameRefinerySpeed/$oresBaseProcessingTime;
    }

    public function gatherIngotData() {
        $stmt = $this->dbase->prepare("SELECT * FROM ingot_ores WHERE ore_id=" . $this->oreId);
        $stmt->execute();
        $stmtData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->dbase->prepare("SELECT * FROM ingots WHERE id=" . $stmtData['ingot_id']);
        $stmt->execute();
        $this->ingotData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->orePerIngot = $this->ingotData['oreRequired'];
    }

    public function gatherRefineryData()
    {
        $refinery = new refinery();
        $this->baseGameRefinerySpeed = (is_null($refinery->baseRefinerySpeed)) ? 0 : $refinery->baseRefinerySpeed;
    }

    public function setBaseValue()
    {
        $refineryCostPerHour        = $this->baseRefineryKilowattPerHourUsage*$this->costPerKilowattHour;
        $drillingCostPerHour        = $this->magicData['drill_kw_hour']*$this->costPerKilowattHour;
        $laborCostPerHour           = $this->magicData['base_labor_per_hour'];
        $foundationalOreRequired    = $this->foundationIngotData['oreRequired'];
        $scalingModifier            = $this->serverData['scaling_modifier'];
        $perHourCosts               = $refineryCostPerHour+$drillingCostPerHour+$laborCostPerHour;
        $this->baseValue            = $perHourCosts*($this->orePerIngot/$foundationalOreRequired)*$scalingModifier;
    }
    
    public function getRefineryKiloWattHour()
    {
        return $this->baseRefineryKilowattPerHourUsage/($this->refiningTimePerOre)/60/60;

    }

	public function getRefineryTime()
	{
		return  (empty($this->oreData['base_processing_time_per_ore'])) ? null : $this->baseGameRefinerySpeed/$this->refiningTimePerOre;
	}

	public function getOreRequiredPerIngot()
    {
        return $this->orePerIngot;
    }

    public function getBaseValue()
    {
        return $this->baseValue;
    }

    public function getStoreAdjustedValue()
    {
        return $this->storeAdjustedValue;
    }

    public function getScarcityAdjustedValue()
    {
        return $this->scarcityAdjustedValue;
    }

}