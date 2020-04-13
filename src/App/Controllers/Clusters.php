<?php namespace Controllers;

use Interfaces\Crud;
use Models\Clusters as DataSource;

/**
 * Class Clusters
 *
 * @package Controllers
 */
class Clusters extends BaseController implements Crud
{
    public $dataSource;

    public function __construct($clusterId)
    {
        $this->clusterId    = $clusterId;
        $this->dataSource   = new DataSource();
    }

    public function create($data) {
        $cluster = $this->dataSource;
        $cluster->title                         = $data->title;
        $cluster->economy_ore                   = $data->economy_ore;
        $cluster->economy_stone_modifier        = $data->economy_stone_modifier;
        $cluster->scaling_modifier              = $data->scaling_modifier;
        $cluster->economy_ore_value             = $data->economy_ore_value;
        $cluster->asteroid_scarcity_modifier    = $data->asteroid_scarcity_modifier;
        $cluster->planet_scarcity_modifier      = $data->planet_scarcity_modifier;
        $cluster->base_modifier                 = $data->base_modifier;
        $cluster->save();

        return $cluster->id;
    }
}