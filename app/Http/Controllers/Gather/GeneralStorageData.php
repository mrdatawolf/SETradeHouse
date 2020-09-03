<?php namespace App\Http\Controllers\Gather;

use App\Http\Traits\CheckNames;
use App\NpcStorageValues;
use App\UserItems;
use App\UserStorageValues;
use Carbon\Carbon;

class GeneralStorageData
{
    use CheckNames;


    protected $serverId;
    protected $worldId;
    protected $isInitial;

    public function __construct($isInitial, $serverId, $worldId) {
        $this->isInitial = $isInitial;
        $this->serverId = $serverId;
        $this->worldId = $worldId;
    }
    public function upateUserAndNpcStorageValues() {
        $userItems = new UserItems();
        if (! $this->isInitial) {
            $userItems = $userItems->where('Timestamp', '>', Carbon::now()->subDay());
        }
        $runningTotals = [];
        $userItems->chunk(400, function ($userItems) use($runningTotals) {
            foreach ($userItems as $row) {
                $owner = $row['Owner'];
                $amount = $row['Qty'];
                $group = $this->seNameToGroup($row['Item']);
                if(! empty($group->id) && ! empty($owner)) {
                    $item  = $this->seNameToItem($group, $row['Item']);
                    $isNpc = (substr($owner,0,4) === 'NPC ');
                    if(!empty($item->id)) {
                        $storages = ($isNpc) ? new NpcStorageValues() : new UserStorageValues();
                        $amount = $this->getCurrentAmount($owner, $group->id, $item->id, $runningTotals, $amount);
                        $runningTotals[$owner][$group->id][$item->id] = $amount;
                        $storages->updateOrCreate(
                            [
                                'owner'     => $owner,
                                'item_id'   => $item->id,
                                'group_id'  => $group->id,
                                'server_id' => $this->serverId,
                                'world_id'  => $this->worldId
                            ],
                            [
                                'amount' => $amount
                            ]
                        );
                    }
                }
            }
        });
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
