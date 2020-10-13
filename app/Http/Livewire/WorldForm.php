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
    public $rarityPercentages;
    public $worldsCount;
    public $worldTypesAllowed;


    public function submit()
    {
        $validatedData = $this->validate([
            'title'             => 'required',
            'serverId'          => 'required',
            'typeId'            => 'required',
            'systemStockWeight' => 'required',
            'shortName'         => 'required'
        ]);

        Worlds::create($validatedData);

        return redirect()->to('/admin/worlds/create');
    }


    public function render()
    {
        $this->serverId          = \Session::get('serverId');
        $server                  = Servers::find($this->serverId);
        $this->worldsCount       = $server->worlds()->count();
        $this->ratio             = $server->ratio;
        $this->rarity            = $server->getWorldsRarityTotals();
        $this->worldTypesAllowed = $this->getAllowedWorlds();

        return view('livewire.world-form', [
            'ratio'             => $this->ratio,
            'rarity'            => $this->rarity,
            'worldsCount'       => $this->worldsCount,
            'worldTypesAllowed' => $this->worldTypesAllowed,
            'serverId'          => $this->serverId,
            'rarityPercentages' => $this->rarityPercentages
        ]);
    }


    private function getAllowedWorlds()
    {
        $totalWorlds            = $this->worldsCount;
        $rarityTotals           = $this->rarity;
        $possibleWorldAvailable = false;
        $worldsAllowed          = [];
        $rarityPercentages      = [];
        foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $rarityId) {
            $rareData       = Rarity::find($rarityId);
            $percentMaximum = (int)$this->ratio[$rareData->title] ?? 0;
            if (empty($rarityTotals[$rarityId])) {
                $rarityPercentage = 0;
            } else {
                $rarityPercentage = floor(($rarityTotals[$rarityId]['total'] / $totalWorlds) * 100);
            }
            $rarityPercentages[] = ['title' => $rareData->title, 'percentage' => $rarityPercentage];
            $isAllowed           = ($rareData->minimum_for_first >= $totalWorlds && $rarityPercentage <= $percentMaximum);
            if ($isAllowed) {
                $worldsAllowed[$rarityId] = $rareData->title;
                $possibleWorldAvailable   = true;
            }
        }
        if ( ! $possibleWorldAvailable) {
            $rareData         = Rarity::find(1);
            $worldsAllowed[1] = $rareData->title;
            $rareData         = Rarity::find(2);
            $worldsAllowed[2] = $rareData->title;
        }
        $this->rarityPercentages = collect($rarityPercentages);

        return $worldsAllowed;
    }
}
