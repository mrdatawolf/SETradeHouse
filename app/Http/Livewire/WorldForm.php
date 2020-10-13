<?php namespace App\Http\Livewire;

use App\Models\Rarity;
use App\Models\Ratios;
use App\Models\Servers;
use Livewire\Component;
use App\Models\Worlds;

class WorldForm extends Component
{
    public $title;
    public $serverId;
    public $typeId;
    public $systemStockWeight;
    public $shortName;
    public $ratio;
    public $rarity;
    public $worldsCount;
    public $worldsAllowed;

    public function submit()
    {
        $validatedData = $this->validate([
            'title' => 'required',
            'serverId' => 'required',
            'typeId' => 'required',
            'systemStockWeight' => 'required',
            'shortName' => 'required'
        ]);

        Worlds::create($validatedData);

        return redirect()->to('/admin/worlds/create');
    }

    public function render()
    {
        $this->serverId = \Session::get('serverId');
        $server = Servers::find($this->serverId);
        $this->worldsCount = $server->worlds()->count();
        $this->ratio = $server->ratio;
        $this->rarity = $server->getWorldsRarityTotals();
        $this->worldsAllowed = $this->getAllowedWorlds();

        return view('livewire.world-form', ['ratio' => $this->ratio, 'rarity' => $this->rarity, 'worldsCount' => $this->worldsCount, 'worldsAllowed' => $this->worldsAllowed]);
    }


    private function getAllowedWorlds() {
        $totalWorlds = $this->worldsCount;
        $rarityTotals = $this->rarity;
        $possibleWorldAvailable = false;
        $worldsAllowed = [];
        foreach([1,2,3,4,5,6,7,8] as $rarityId) {
            $rareData = Rarity::find($rarityId);
            $percentMaximum   = (int)$this->ratio[$rareData->title] ?? 0;
            if(empty($rarityTotals[$rarityId])) {
                $rarityPercentage = 0;
            } else {
                $rarityPercentage = floor(($rarityTotals[$rarityId]['total'] / $totalWorlds) * 100);
            }
            $isAllowed = ($rareData->minimum_for_first > $totalWorlds && $rarityPercentage < $percentMaximum);
            $worldsAllowed[$rarityId] = $isAllowed;
            if($isAllowed) {
                $possibleWorldAvailable = true;
            }
        }
        if(! $possibleWorldAvailable) {
            $worldsAllowed[1] = true;
            $worldsAllowed[2] = true;
        }

        return $worldsAllowed;
    }
}
