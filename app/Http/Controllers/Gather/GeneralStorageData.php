<?php namespace App\Http\Controllers\Gather;

use App\Http\Traits\FindingGoods;
use App\NpcStorageValues;
use App\UserItems;
use App\UserStorageValues;
use Carbon\Carbon;

class GeneralStorageData
{
    use FindingGoods;


    protected $serverId;
    protected $worldId;
    protected $isInitial;

    public function __construct($isInitial, $serverId, $worldId) {
        $this->isInitial = $isInitial;
        $this->serverId = $serverId;
        $this->worldId = $worldId;
    }
    public function upateUserAndNpcStorageValues()
    {
        $userItems = new UserItems();
        if ( ! $this->isInitial) {
            $userItems = $userItems->where('Timestamp', '>', Carbon::now()->subDay());
        }
        if ($userItems->count() >= 1) {
            $runningTotals = [];
            $userItems->chunk(400, function ($userItems) use ($runningTotals) {
                foreach ($userItems as $row) {
                    $owner           = $row['Owner'];
                    $goodType        = $this->seNameToGoodType($row['Item']);
                    if ( ! empty($goodType->id) && ! empty($owner)) {
                        $amount          = $row['Qty'];
                        $originTimestamp = $row['Timestamp'];
                        $good  = $this->seNameToGood($row['Item']);
                        $isNpc = (substr($owner, 0, 4) === 'NPC ');
                        if ( ! empty($good->id)) {
                            $storages                                        = ($isNpc) ? new NpcStorageValues()
                                : new UserStorageValues();
                            $amount                                          = $this->getCurrentAmount($owner,
                                $goodType->id, $good->id, $runningTotals, $amount);
                            $runningTotals[$owner][$goodType->id][$good->id] = $amount;
                            $storages->updateOrCreate([
                                'owner'     => $owner,
                                'item_id'   => $good->id,
                                'group_id'  => $goodType->id,
                                'server_id' => $this->serverId,
                                'world_id'  => $this->worldId
                            ], [
                                    'amount'           => $amount,
                                    'origin_timestamp' => $originTimestamp
                                ]);
                        }
                    }
                }
            });
        }
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
