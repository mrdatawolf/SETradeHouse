<?php namespace Controllers;

use Interfaces\Crud;
use Models\Servers as DataSource;

/**
 * Class Servers
 *
 * @package Controllers
 */
class Servers extends BaseController implements Crud
{
    public function __construct($clusterId)
    {
        $this->clusterId    = $clusterId;
        $this->dataSource   = new DataSource();
    }
    public function create($data) {
        $server = new DataSource();
        $server->title = $data->title;
        $server->system_stock_weight = $data->systemStockWeight;
        $server->save();


        return $server->id;
    }
}