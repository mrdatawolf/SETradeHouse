<?php namespace App\Http\Controllers\Gather;

use App\Http\Traits\FindingGoods;
use App\Models\NpcStorageValues;
use App\Models\OwnerServer;
use App\Models\UserItems;
use App\Models\UserStorageValues;
use Carbon\Carbon;

class GeneralStorageData
{
    use FindingGoods;

    protected $serverId;
    protected $worldId;
    protected $isInitial;
    protected $extended;
    protected $result;

    public function __construct($isInitial, $extended, $serverId, $worldId)
    {
        $this->isInitial = $isInitial;
        $this->extended  = $extended;
        $this->serverId  = $serverId;
        $this->worldId   = $worldId;
    }


    public function upateUserAndNpcStorageValues()
    {
        $this->result = 'upateUserAndNpcStorageValues : Success';
        $oldestHourToPull = ($this->extended) ? $this->extended : 6;
        $utcOffset = 7;
        $userItems = new UserItems();
        if ( ! $this->isInitial) {
            $userItems = $userItems->orderBy('Timestamp')->where('Timestamp', '>', Carbon::now()->subhours($oldestHourToPull+$utcOffset));
        }
        if ($userItems->count() >= 1) {
            $runningTotals = [];
            $userItems->chunk(400, function ($userItems) use ($runningTotals) {
                foreach ($userItems as $row) {
                    $owner    = $row['Owner'];
                    $this->addOwnerToOwnerServer($owner);
                    $goodType = $this->seNameToGoodType($row['Item']);
                    if ( ! empty($goodType->id) && ! empty($owner)) {
                        $amount          = $row['Qty'];
                        $originTimestamp = $row['Timestamp'];
                        $good            = $this->seNameToGood($row['Item']);
                        $isNpc           = (substr($owner, 0, 4) === 'NPC ');
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
                    } else {
                        $this->result = 'upateUserAndNpcStorageValues : goodtype not found or owner was empty';
                    }
                }
            });
        } else {
            $this->result = 'upateUserAndNpcStorageValues : No useritems found inside the last ' . $oldestHourToPull;
        }

        return $this->result;
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
    private function getCurrentAmount($owner, $groupId, $itemId, $runningTotals, $amount)
    {

        return empty($runningTotals[$owner][$groupId][$itemId]) ? $amount
            : $runningTotals[$owner][$groupId][$itemId] + $amount;
    }

    private function addOwnerToOwnerServer($owner) {
        //select DISTINCT Owner FROM everyonesitems WHERE Owner NOT LIKE 'NPC%';
        OwnerServer::firstOrCreate([
            'owner_title' => $owner,
            'server_id' => 1
        ]);
    }
}
