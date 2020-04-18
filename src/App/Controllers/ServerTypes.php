<?php namespace Controllers;

use Models\ServerTypes as SystemType;

/**
 * Class ServerTypes
 *
 * @package Controllers
 */
class ServerTypes
{

    public function create($title, $oreRequired, $baseOre, $keenCrapFix) {
        $systemType = new SystemType();
        $systemType->title = $title;
        $systemType->save();


        return $systemType->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = SystemType::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (SystemType::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return SystemType::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}