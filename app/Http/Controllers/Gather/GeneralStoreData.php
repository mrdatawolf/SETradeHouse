<?php namespace App\Http\Controllers\Gather;

use App\Http\Traits\FindingGoods;
use App\Models\InActiveTransactions;
use App\Models\Stores;
use App\Models\TradeZones;
use App\Models\Transactions;
use App\Models\TransactionTypes;
use Carbon\Carbon;
use GuzzleHttp\Client;

class GeneralStoreData
{
    use FindingGoods;

    protected $serverId;
    protected $isInitial;
    protected $extended;
    protected $transactionArray;
    protected $result;
    protected $apiData;

    public function __construct($isInitial, $extended, $serverId) {
        $this->isInitial = $isInitial;
        $this->extended = $extended;
        $this->serverId = $serverId;
        $this->transactionArray = [];
    }

    public function apiDataWithoutKey($apiLocation)
    {
        $client = new Client(); //GuzzleHttp\Client
        $response = $client->request('GET', $apiLocation, [
            'verify'  => false,
        ]);

        return json_decode($response->getBody());
    }

    public function gatherApiData($location)
    {
        switch($location) {
            case 'Carmenta':
                $uri = 'http://104.220.208.195:8050/carmenta';
                break;
            default :
                $uri = 'http://104.220.208.195:8050/general';
        }
        $this->apiData = $this->apiDataWithoutKey($uri);
    }


    /**
     * @param $apiData
     *
     * @return object
     */
    private function getgoodType($apiData): object
    {
        if($apiData[1] === 'Other' && in_array($apiData[2],['HydrogenBottle', 'OxygenBottle'])) {
            $type = 'Bottle';
        } elseif ($apiData[1] === 'Other' && in_array($apiData[2],['NATO_5p56x45mm'])) {
            $type = 'Ammo';
        } else {
            $type = $apiData[1];
        }

        return (object)['id' => $this->getGoodTypeId($type)];
    }


    /**
     * @param $worldId
     *
     * @return string
     */
    public function processApiData($worldId): string
    {
        $this->result = 'processApiData: Success';
        foreach ($this->apiData->data as $apiData) {
            $goodType = $this->getgoodType($apiData);
            $goodValue = ($goodType->id <= 2) ? strtolower($apiData[2]) : $apiData[2];
            $good = $this->getGoodFromGoodTypeAndGoodTitle($goodType, $goodValue);
            if ( ! empty($good)) {
                $transaction = (object)[
                    'gridName' => $apiData[6],
                    'Owner' => $apiData[5],
                    'GPSString' => "GPS:" . $apiData[6] . ":" . $apiData[7] . ":" . $apiData[8] . ":" . $apiData[9],
                    'pricePerUnit' => $apiData[3],
                    'Qty' => $apiData[4],
                    'offerOrOrder' => $apiData[0]
                ];

                $tradeZone = $this->getTZ($transaction, $worldId);
                $transaction->trade_zone_id = $tradeZone->id;
                $this->updateStoreLocation($tradeZone, $transaction->GPSString);
                $this->addTransactionToArray($tradeZone, $transaction, $goodType, $good, $worldId);
            } else {
                switch($apiData[2]) {
                    case 'Welder1Item':
                    case 'HandDrill1Item':
                        //do nothing
                    break;
                    default :
                        $this->result = 'processApiData: good was empty for transaction:' . json_encode($apiData);
                }
            }
        }

        return $this->result;
    }

    public function applyTransactions() {
        $this->moveActiveTransactionsToInactive();
        $this->addActiveTransactions();
    }


    /**
     * note: take the current stores values and replace the active transaction with the new values. This also moves all old data to the inactive table.
     */
    public function updateTransactionValues($worldId): string
    {
        $this->result = 'updateTransactionValues: Success';
        $storeTransactions = new Stores();
        $storeTransactions->chunk(400, function ($storeTransactions, $worldId) {
            foreach ($storeTransactions as $transaction) {
                $goodType = $this->seNameToGoodType($transaction->Item);
                $good = $this->seNameAndGoodTypeToGood($goodType, $transaction->Item);
                if ( ! empty($good)) {
                    $tradeZone = $this->getTZ($transaction, $worldId);
                    $this->updateStoreLocation($tradeZone, $transaction->GPSString);
                    $this->addTransactionToArray($tradeZone, $transaction, $goodType, $good, $worldId);
                } else {
                    $this->result = 'updateTransactionValues: good was empty for transaction Item:' . $transaction->Item . ' goodType: ' . $goodType->title;
                }
            }
        });
        $this->moveActiveTransactionsToInactive();
        $this->addActiveTransactions();

        return $this->result;
    }


    /**
     * note: take the array and add them to the transactions table.
     */
    private function addActiveTransactions() {
        foreach($this->transactionArray as $transaction){
            $transactionModel = new Transactions();
            $transactionModel->create($transaction);
        }
        \Session::put('newest_db_date', Carbon::now()->toDateTimeString());
    }


    /**
     * note: add the data we need to the transaction array.
     * @param $tradeZone
     * @param $transaction
     * @param $goodType
     * @param $good
     * @param $worldId
     */
    private function addTransactionToArray($tradeZone, $transaction, $goodType, $good, $worldId) {
        if(! empty($transaction->Owner)) {
            $currentTransaction       = [
                'trade_zone_id'       => $tradeZone->id,
                'server_id'           => $this->serverId,
                'world_id'            => $worldId,
                'value'               => $transaction->pricePerUnit,
                'amount'              => $transaction->Qty,
                'transaction_type_id' => $this->getTransactionId($transaction),
                'good_type_id'        => $goodType->id,
                'good_id'             => $good->id,
                'owner'               => $transaction->Owner
            ];
            $this->transactionArray[] = $currentTransaction;
        }
    }


    /**
     * note: take the transactions in transactions table and move them to the inactive table.  This is gives us the history on each update.
     */
    private function moveActiveTransactionsToInactive() {
        $transactions = new Transactions();
        $transactions->chunk(400, function ($transactions) {
            foreach($transactions as $transaction) {
                $inActiveTransactionModel = new InActiveTransactions();
                $inActiveTransactionModel->create($transaction->toArray());
                $transaction->delete();
            }
        });
    }


    /**
     * @param $tradeZone
     * @param $gps
     */
    public function updateStoreLocation($tradeZone, $gps) {
        $tradeZone->gps = $gps;
        $tradeZone->save();
    }


    /**
     * @param $transaction
     *
     * @return int
     */
    private function getTransactionId($transaction) {
        $tranactionTypeConversion   = ($transaction->offerOrOrder === 'Offer') ? 'sell' : 'buy';
        $transactionType            = TransactionTypes::where('title', $tranactionTypeConversion)->first();

        return (! empty($transactionType->id)) ? $transactionType->id : null;
    }

    /**
     * @param $transaction
     *
     * @return mixed
     */
    private function getTZ($transaction, $worldId) {
        $tzTitle = str_replace('"', "", $transaction->gridName);
        $tzTitle = str_replace("'", "", $tzTitle);
        $owner = str_replace('"', "", $transaction->Owner);
        $owner = str_replace("'", "", $owner);
        $tradeZones = new TradeZones();
        $gps        = $transaction->GPSString;

        return $tradeZones->firstOrCreate(
            [
                'title' => $tzTitle,
                'owner' => $owner,
                'server_id' => $this->serverId,
                'world_id' => $worldId
            ],
            [
                'local_weight'  => 4,
                'gps'           => $gps
            ]
        );
    }


    /**
     * @param $owner
     * @param $groupId
     * @param $itemId
     * @param $runningTotals
     * @param $amount
     *
     * @return int
     */
    private function getCurrentAmount($owner, $groupId, $itemId, $runningTotals, $amount) {

        return empty($runningTotals[$owner][$groupId][$itemId]) ? $amount : $runningTotals[$owner][$groupId][$itemId] + $amount;
    }
}
