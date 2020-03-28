<?php namespace Controllers;

use Models\Ingots as Ingot;

/**
 * Class Ingots
 *
 * @package Controllers
 */
class Ingots
{

    public function create($title, $oreRequired, $baseOre, $keenCrapFix) {
        $ingot = new Ingot();
        $ingot->title = $title;
        $ingot->ore_required = $oreRequired;
        $ingot->base_ore = $baseOre;
        $ingot->keen_crap_fix = $keenCrapFix;
        $ingot->save();


        return $ingot->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = Ingot::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (Ingot::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return Ingot::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}