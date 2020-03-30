<?php namespace Controllers;

use Interfaces\Crud;
use Models\MagicNumbers as DataSource;

/**
 * Class MagicNumbers
 *
 * @package Controllers
 */
class MagicNumbers extends BaseController implements Crud
{
    public function __construct()
    {
        $this->clusterId = null;
        $this->dataSource   = new DataSource();
    }
    public function create($data) {
        //we shouldn't actually ever create a new row...
        /*$magicNumber = new DataSource();
        $magicNumber->receipt_base_efficiency           = $data->receiptBaseEfficiency;
        $magicNumber->base_multiplier_for_buy_vs_sell   = $data->baseMultiplierForBuyVsSell;
        $magicNumber->base_refinery_kwh                 = $data->baseRefineryKwh;
        $magicNumber->base_refinery_speed               = $data->baseRefinerySpeed;
        $magicNumber->base_drill_per_kw_hour            = $data->baseDrillPerKwHour;
        $magicNumber->markup_for_each_leg               = $data->markupForEachLeg;
        $magicNumber->markup_total_change               = $data->markupTotalChange;
        $magicNumber->base_weight_for_system_stock      = $data->baseWeightForSystemStock;
        $magicNumber->other_server_weight               = $data->otherServerWeight;
        $magicNumber->distance_weight                   = $data->distanceWeight;
        $magicNumber->server_id                         = $data->serverId;
        $magicNumber->cost_kw_hour                      = $data->costKwHour;
        $magicNumber->base_labor_per_hour               = $data->baseLaborPerHour;
        $magicNumber->save();

        return true;*/
    }

    public function getOreGatherCost() {
        $data = $this->dataSource->first();

        return ($data->base_refinery_kwh + $data->base_drill_per_kw_hour + $data->base_labor_per_hour) /60 /60;
    }

}