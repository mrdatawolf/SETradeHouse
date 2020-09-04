<?php namespace App\Http\Controllers\Gather;

use App\Http\Traits\CheckNames;
use App\InactiveTransactions;
use App\Stores;
use App\TradeZones;
use App\Transactions;
use App\TransactionTypes;

class GeneralStoreData
{
    use CheckNames;

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

    public function updateTransactionValues() {
        //gather stores
        $storeTransactions = new Stores();
        $storeTransactions->chunk(400, function ($storeTransactions) {
            foreach ($storeTransactions as $transaction) {
                $group = $this->seNameToGroup($transaction->Item);
                $item  = $this->seNameToItem($group, $transaction->Item);
                if ( ! empty($item)) {
                    $tradeZone = $this->getTZ($transaction);
                    $currentTransaction    = [
                        'trade_zone_id'       => $tradeZone->id,
                        'server_id'           => $this->serverId,
                        'world_id'            => $this->worldId,
                        'value'               => $transaction->pricePerUnit,
                        'amount'              => $transaction->Qty,
                        'transaction_type_id' => $this->getTransactionId($transaction),
                        'good_type_id'        => $group->id,
                        'good_id'             => $item->id,
                        'owner'               => $transaction->Owner
                    ];
                    $this->transactionArray[] = $currentTransaction;
                }
            }
        });

        $transactions = new Transactions();
        $transactions->chunk(400, function ($transactions) {
           foreach($transactions as $transaction) {
               $inActiveTransactionModel = new InactiveTransactions();
               $inActiveTransactionModel->create($transaction->toArray());
               $transaction->delete();
           }
        });
        $allintests = [];
        foreach($this->transactionArray as $transaction){ //$transaction array contains input data
            $transactionModel = new Transactions();
            $transactionModel->create($transaction);
        }
    }

    public function updateStoreLocation() {
        //todo: this needs to be done
    }

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
