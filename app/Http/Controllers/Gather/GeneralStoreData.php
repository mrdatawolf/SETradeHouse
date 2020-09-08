<?php namespace App\Http\Controllers\Gather;

use App\Http\Traits\FindingGoods;
use App\InactiveTransactions;
use App\Stores;
use App\TradeZones;
use App\Transactions;
use App\TransactionTypes;

class GeneralStoreData
{
    use FindingGoods;

    protected $serverId;
    protected $worldId;
    protected $isInitial;
    protected $transactionArray;

    public function __construct($isInitial, $serverId, $worldId) {
        $this->isInitial = $isInitial;
        $this->serverId = $serverId;
        $this->worldId = $worldId;
        $this->transactionArray = [];
    }


    /**
     * note: take the current stores values and replace the active transactiosn with the new values. this also moves all old data to the inactive table.
     */
    public function updateTransactionValues() {
        $storeTransactions = new Stores();
        $storeTransactions->chunk(400, function ($storeTransactions) {
            foreach ($storeTransactions as $transaction) {
                $good = $this->seNameToGood($transaction->Item);
                $goodType = $this->seNameToGoodType($transaction->Item);
                if ( ! empty($good)) {
                    $tradeZone = $this->getTZ($transaction);
                    $this->updateStoreLocation($tradeZone, $transaction->GPSString);
                    $this->addActiveTransactionToArray($tradeZone, $transaction, $goodType, $good);
                }
            }
        });
        $this->moveActiveTransactionsToInactive();
        $this->addActiveTransactions();
    }


    /**
     * note: take the array and add them to the transactions table.
     */
    private function addActiveTransactions() {
        foreach($this->transactionArray as $transaction){
            $transactionModel = new Transactions();
            $transactionModel->create($transaction);
        }
    }


    /**
     * note: add the data we ned to the transaction array.
     * @param $tradeZone
     * @param $transaction
     * @param $goodType
     * @param $good
     */
    private function addActiveTransactionToArray($tradeZone, $transaction, $goodType, $good) {
        $currentTransaction    = [
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
    }


    /**
     * note: take the transactions in transactions table and move them to the inactive table.  This is gives us the history on each update.
     */
    private function moveActiveTransactionsToInactive() {
        $transactions = new Transactions();
        $transactions->chunk(400, function ($transactions) {
            foreach($transactions as $transaction) {
                $inActiveTransactionModel = new InactiveTransactions();
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

        return $transactionType->id;
    }

    /**
     * @param $transaction
     *
     * @return mixed
     */
    private function getTZ($transaction) {
        $tzTitle    = $transaction->gridName;
        $owner      = $transaction->Owner;
        $tradeZones = new TradeZones();

        return $tradeZones->firstOrCreate(
            [
                'title' => $tzTitle,
                'owner' => $owner,
                'server_id' => $this->serverId,
                'world_id' => $this->worldId
            ],
            [
                'local_weight' => 4
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
