<?php namespace Controllers;

use Models\Servers as Server;

/**
 * Class Servers
 *
 * @package Controllers
 */
class Servers
{

    public function create($title, $systemStockWeight) {
        $server = new Server();
        $server->title = $title;
        $server->system_stock_weight = $systemStockWeight;
        $server->save();


        return $server->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = Server::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (Server::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return Server::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}