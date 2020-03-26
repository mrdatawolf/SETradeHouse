<?php namespace Old;


use Illuminate\Database\Eloquent\Model;

class MagicNumbers extends Model
{
    protected $data;

    public function __construct()
    {
        parent::__construct();
        $this->gatherData();
    }


    private function gatherData() {
        $this->data                        = $this->gatherFromTable('magic_numbers')[0];
        $this->baseRefineryKilowattPerHourUsage = $this->data->base_refinery_kwh;
        $this->costPerKilowattHour              = $this->data->cost_kw_hour;
        $this->baseRefineryCostPerHour          = $this->data->base_refinery_kwh*$this->data->cost_kw_hour;
        $this->baseDrillCostPerHour             = $this->data->base_drill_per_kw_hour*$this->data->cost_kw_hour;
    }

    public function getBaseEfficiency() {
        return $this->data->receipt_base_efficiency;
    }

    public function getBaseMultiplierForBuyVsSell() {
        return $this->data->base_multiplier_for_buy_vs_sell;
    }

    public function getBaseRefineryKWh() {
         return $this->data->base_refinery_kwh;
    }

    public function getCostPerKWh() {
        return $this->data->cost_kw_hour;
    }

    public function getBaseRefinerySpeed() {
        return $this->data->base_refinery_speed;
    }

    public function getBaseLaborPerHour() {
        return $this->data->base_labor_per_hour;
    }

    public function getDrillKWPerHour() {
        return $this->data->base_drill_per_kw_hour;
    }

    public function getOreGatherCost() {
        return $this->baseRefineryCostPerHour+$this->baseDrillCostPerHour+$this->data->base_labor_per_hour/60/60;
    }

    public function getWeightForSystemStock() {
        return $this->data->base_weight_for_system_stock;
    }


}