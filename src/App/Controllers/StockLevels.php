<?php namespace Controllers;

use Models\StockLevels as StockLevel;

/**
 * Class Stations
 *
 * @package Controllers
 */
class StockLevels
{

    public function create($title, $serverId) {
        $stock              = new StockLevel();
        $stock->server_id   = $title;
        $stock->user_id     = $title;
        $stock->amount      = $serverId;
        $stock->good_type   = $serverId;
        $stock->good_id     = $serverId;
        $stock->save();

        return $stock->id;
    }

    public static function headers() {
        $headers = [];
        $stockLevel = StockLevel::first();
        if(!empty($stockLevel)) {
            $rowArray = $stockLevel->toArray();
            foreach (array_keys($rowArray) as $key) {
                $headers[] = $key;
            }
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (StockLevel::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return StockLevel::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}