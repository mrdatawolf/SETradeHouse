<?php namespace Core;

use DB\dbClass;

class MagicNumbers extends dbClass
{
    public function __construct()
    {
        parent::__construct();
        //we don't get magicData because dbClass already does that.
    }

    public function getBaseEfficiency() {
        return $this->magicData->receipt_base_efficiency;
    }

    public function getBaseMultiplierForBuyVsSell() {
        return $this->magicData->base_multiplier_for_buy_vs_sell;
    }

    public function getBaseRefineryKWh() {
         return $this->magicData->base_refinery_kwh;
    }

    public function getCostPerKWh() {
        return $this->magicData->cost_kw_hour;
    }

    public function getBaseRefinerySpeed() {
        return $this->magicData->base_refinery_speed;
    }

    public function getBaseLaborPerHour() {
        return $this->magicData->base_labor_per_hour;
    }

    public function getDrillKWPerHour() {
        return $this->magicData->base_drill_per_kw_hour;
    }

    public function getOreGatherCost() {
        return $this->baseRefineryCostPerHour+$this->baseDrillCostPerHour+$this->getBaseLaborPerHour()/60/60;
    }

    public function getWeightForSystemStock() {
        return $this->magicData->base_weight_for_system_stock;
    }


}