<?php namespace Controllers;

use Models\Clusters as Cluster;

/**
 * Class Clusters
 *
 * @package Controllers
 */
class Clusters
{

    public function create($title, $economy_ore, $economy_stone_modifier, $scaling_modifier, $economy_ore_value, $asteroid_scarcity_modifier,$planet_scarcity_modifier, $base_modifier) {
        $cluster = new Cluster();
        $cluster->title = $title;
        $cluster->economy_ore = $economy_ore;
        $cluster->economy_stone_modifier = $economy_stone_modifier;
        $cluster->scaling_modifier = $scaling_modifier;
        $cluster->economy_ore_value = $economy_ore_value;
        $cluster->asteroid_scarcity_modifier = $asteroid_scarcity_modifier;
        $cluster->planet_scarcity_modifier = $planet_scarcity_modifier;
        $cluster->base_modifier = $base_modifier;
        $cluster->save();


        return $cluster->id;
    }

    public static function headers() {
        $headers = [];
        $rowArray = Cluster::first()->toArray();
        foreach (array_keys($rowArray) as $key) {
            $headers[] = $key;
        }

        return $headers;
    }

    public static function rows() {
        $rows = [];
        foreach (Cluster::get()->toArray() as $key => $value) {
            foreach($value as $column => $columnValue) {
                $rows[$key][] = $columnValue;
            }
        }

        return $rows;
    }

    public static function read() {
        return Cluster::all();
    }

    public static function update() {

    }

    public static function delete() {

    }

}