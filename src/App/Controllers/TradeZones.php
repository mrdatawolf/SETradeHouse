<?php namespace Controllers;

use Models\TradeZones as TradeZone;

/**
 * Class TradeZones
 *
 * @package Controllers
 */
class TradeZones
{

    public function create($title, $ownerId, $stationId) {
        $ingot = new TradeZone();
        $ingot->title = $title;
        $ingot->owner_id = $ownerId;
        $ingot->station_id = $stationId;
        $ingot->save();


        return $ingot->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = TradeZone::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (TradeZone::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return TradeZone::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}