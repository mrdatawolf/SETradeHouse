<?php namespace Controllers;

use Interfaces\Crud;
use Models\Stocks as DataSource;

/**
 * Class Clusters
 *
 * @package Controllers
 */
class Stocks extends BaseController implements Crud
{
    public $dataSource;

    public function __construct()
    {
        $this->dataSource   = new DataSource();
    }


    public function create($data) {
        $stock = $this->dataSource;
        $stock->cluster_id  = $data->clusterId;
        $stock->server_id   = $data->serverId;
        $stock->station_id  = $data->stationId;
        $stock->stock_type  = $data->stockType;
        $stock->stock_type  = $data->currentAmount;
        $stock->stock_type  = $data->desiredAmount;
        $stock->save();

        return true;
    }
}