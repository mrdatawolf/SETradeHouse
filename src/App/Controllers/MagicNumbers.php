<?php namespace Controllers;

use Models\MagicNumbers as MagicNumber;

/**
 * Class MagicNumbers
 *
 * @package Controllers
 */
class MagicNumbers
{
    public function create($receiptBaseEfficiency, $baseMultiplierForBuyVsSell, $baseRefineryKwh, $baseRefinerySpeed, $baseDrillPerKwHour, $markupForEachLeg, $markupTotalChange, $baseWeightForSystemStock, $otherServerWeight, $distanceWeight, $serverId, $costKwHour, $baseLaborPerHour) {
        $magicNumber = new MagicNumber();
        $magicNumber->receipt_base_efficiency = $receiptBaseEfficiency;
        $magicNumber->base_multiplier_for_buy_vs_sell = $baseMultiplierForBuyVsSell;
        $magicNumber->base_refinery_kwh = $baseRefineryKwh;
        $magicNumber->base_refinery_speed = $baseRefinerySpeed;
        $magicNumber->base_drill_per_kw_hour = $baseDrillPerKwHour;
        $magicNumber->markup_for_each_leg = $markupForEachLeg;
        $magicNumber->markup_total_change = $markupTotalChange;
        $magicNumber->base_weight_for_system_stock = $baseWeightForSystemStock;
        $magicNumber->other_server_weight = $otherServerWeight;
        $magicNumber->distance_weight = $distanceWeight;
        $magicNumber->server_id = $serverId;
        $magicNumber->cost_kw_hour = $costKwHour;
        $magicNumber->base_labor_per_hour = $baseLaborPerHour;
        $magicNumber->save();


        return 1;
    }

    public static function headers() {
        $headers = [];
        $rowArray = MagicNumber::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (MagicNumber::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return MagicNumber::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}