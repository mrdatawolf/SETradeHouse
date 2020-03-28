<?php namespace Controllers;

use Models\Components as Component;

/**
 * Class Ingots
 *
 * @package Controllers
 */
class Components
{

    public function create($title, $cobalt, $gold, $iron, $magnesium, $nickel, $platinum, $silicon, $silver, $gravel, $uranium, $mass, $volume) {
        $component = new Component();
        $component->title = $title;
        $component->cobalt = $cobalt;
        $component->gold = $gold;
        $component->iron = $iron;
        $component->magnesium = $magnesium;
        $component->nickel = $nickel;
        $component->platinum = $platinum;
        $component->silicon = $silicon;
        $component->silver = $silver;
        $component->gravel = $gravel;
        $component->mass = $mass;
        $component->volume = $volume;
        $component->save();

        return $component->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = Component::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (Component::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return Component::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}