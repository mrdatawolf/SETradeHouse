<?php namespace App\Http\Controllers\Gather;

use App\Http\Traits\FindingGoods;
use App\Models\InActiveTransactions;
use App\Models\Stores;
use App\Models\TradeZones;
use App\Models\Transactions;
use App\Models\TransactionTypes;
use Carbon\Carbon;

class GeneralStoreData
{
    use FindingGoods;

    protected $serverId;
    protected $worldId;
    protected $isInitial;
    protected $extended;
    protected $transactionArray;
    protected $result;

    public function __construct($isInitial, $extended, $serverId, $worldId) {
        $this->isInitial = $isInitial;
        $this->extended = $extended;
        $this->serverId = $serverId;
        $this->worldId = $worldId;
        $this->transactionArray = [];
    }


    /**
     * note: take the current stores values and replace the active transactiosn with the new values. this also moves all old data to the inactive table.
     */
    public function updateTransactionValues() {
        $this->result = 'updateTransactionValues: Success';
        $storeTransactions = new Stores();
        $storeTransactions->chunk(400, function ($storeTransactions) {
            foreach ($storeTransactions as $transaction) {
                $goodType = $this->seNameToGoodType($transaction->Item);
                $good = $this->seNameAndGoodTypeToGood($goodType, $transaction->Item);
                if ( ! empty($good)) {
                    $tradeZone = $this->getTZ($transaction);
                    $this->updateStoreLocation($tradeZone, $transaction->GPSString);
                    $this->addTransactionToArray($tradeZone, $transaction, $goodType, $good);
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
     * note: add the data we ned to the transaction array.
     * @param $tradeZone
     * @param $transaction
     * @param $goodType
     * @param $good
     */
    private function addTransactionToArray($tradeZone, $transaction, $goodType, $good) {
        if(! empty($transaction->Owner)) {
            $currentTransaction       = [
                'trade_zone_id'       => $tradeZone->id,
                'server_id'           => $this->serverId,
                'world_id'            => $this->worldId,
                'value'               => $transaction->pricePerUnit,
                'amount'              => $transaction->Qty,
                'transaction_type_id' => $this->getTransactionId($transaction),
                'good_type_id'        => $goodType->id,
                'good_id'             => $good->id,
                'owner'               => $transaction->Owner
            ];
            $this->transactionArray[] = $currentTransaction;
        } else {
            echo 'No transaction owner found!';
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
    private function getTZ($transaction) {
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
                'world_id' => $this->worldId
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
