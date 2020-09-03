<?php

namespace App\Console\Commands;

use App\Components;
use App\Groups;
use App\Http\Traits\CheckNames;
use App\Ingots;
use App\Ores;
use App\Servers;
use App\Tools;
use App\UserItems;
use App\UserStorageValues;
use App\Worlds;
use Illuminate\Console\Command;

class GatherNebulonData extends Command
{
    use CheckNames;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gather:nebulon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gather data from the nebulon db';

    protected $server_id;
    protected $world_id;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->server_id=Servers::where('title','The Nebulon Cluster')->first();
        $this->world_id=Worlds::where('title','Nebulon')->first();
        //gather everyonesitems
        $this->gatherEveryonesItems();
        //upsert into user_storage_values


        //gather stores
        //check if it is already in the active_transactions
        //if it is move the current transaction to the inactive_transactions
        //add transaction to active_transactions
    }

    private function gatherEveryonesItems() {
        UserItems::chunk(400, function ($userItems) {

            foreach ($userItems as $row) {
                $itemType = $this->seNameToGroup($row['Item']);
                $group = $this->getGroup($row['Item']);
                $owner = $row->Owner;
                if(! empty($group->id)) {
                    $item  = $this->getItem($group->id, $row['Item']);
                    if(!empty($item->id)) {
                        $userStorages = UserStorageValues::where([
                            'owner'     => $owner,
                            'item_id'   => $item->id,
                            'group_id'  => $group->id,
                            'server_id' => $this->server_id,
                            'world_id'  => $this->world_id
                        ]);
                        if ($userStorages->exists()) {
                            $userStorage = $userStorages->first();
                            if ($userStorage->amount === $row->qty) {
                                dd('nothing to do');
                            } else {
                                dd('move the current row to a historical table. Then update this rows amount');
                            }
                        } else {
                            $userStorages->amount = $row->qty;
                            $userStorages->create();
                        }




                        /*if ( ! empty($title)) {
                            $stockLevels[$itemType][$title] = number_format($stockData->where('Item', $item)
                                                                                      ->sum('Qty'));
                        }*/
                    }
                }
            }
        });
    }

    private function getGroup($item) {
        $itemType = $this->seNameToGroup($item);

        return Groups::where('title', $itemType)->first();
    }

    private function getItem($groupId, $seName) {
        $itemType = Groups::find($groupId);
        $title = $this->seNameToTitle($itemType, $seName);

        switch($itemType) {
            case 1 :
                return Ores::where('title', $title)->first();
            case 2 :
                return Ingots::where('title', $title)->first();
            case 3 :
                return Components::where('title', $title)->first();
            case 4 :
                return Tools::where('title', $title)->first();
        }

        return null;
    }
}
