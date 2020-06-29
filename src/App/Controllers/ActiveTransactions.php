<?php namespace Controllers;

use Interfaces\Crud;
use Models\ActiveTransactions as DataSource;

/**
 * Class Clusters
 *
 * @package Controllers
 */
class ActiveTransactions extends BaseController implements Crud
{
    public $dataSource;

    public function __construct()
    {
        $this->dataSource   = new DataSource();
    }


    public function create($data) {
        $transaction = $this->dataSource;
        $transaction->tradestation_id   = $data->tradeStationId;
        $transaction->server_id         = $data->clusterId;
        $transaction->cluster_id        = $data->serverId;
        $transaction->transaction_type  = $data->transactionType;
        $transaction->good_type         = $data->goodType;
        $transaction->good_id           = $data->goodId;
        $transaction->value             = $data->stationId;
        $transaction->amount            = $data->stockType;
        $transaction->created_at        = $data->currentAmount;
        $transaction->updated_at        = $data->desiredAmount;
        $transaction->save();

        return true;
    }

    public function read($data = null) {
        return null;
    }
}