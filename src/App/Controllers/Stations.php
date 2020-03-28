<?php namespace Controllers;

use Models\Stations as Station;

/**
 * Class Stations
 *
 * @package Controllers
 */
class Stations
{

    public function create($title, $serverId) {
        $server = new Station();
        $server->title = $title;
        $server->server_id = $serverId;
        $server->save();


        return $server->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = Station::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (Station::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return Station::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}