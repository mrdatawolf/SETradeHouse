<?php

namespace App\Http\Traits;

use App\Models\Rarity;
use App\Models\Servers;
use App\Models\WorldTypes;

trait worldInfo
{
    public $worldRarityIds = [1, 2, 3, 4, 5, 6, 7, 8];
    public function getRarityPercentages()
    {
        $this->serverId          = \Session::get('serverId');
        $this->server            = Servers::find($this->serverId);
        $totalWorlds            = $this->server->worlds()->count();
        $rarityTotals           = $this->server->getWorldsRarityTotals();
        $rarityPercentages      = [];
        foreach ($this->worldRarityIds as $rarityId) {
            $rareData       = Rarity::find($rarityId);
            $rarityPercentage = (empty($rarityTotals[$rarityId])) ? 0 : floor(($rarityTotals[$rarityId]['total'] / $totalWorlds) * 100);
            $rarityPercentages[] = ['title' => $rareData->title, 'percentage' => $rarityPercentage];
        }

        return collect($rarityPercentages);
    }


    private function getAllowedWorlds()
    {
        $this->serverId          = \Session::get('serverId');
        $this->server            = Servers::find($this->serverId);
        $this->ratio             = $this->server->ratio;
        $totalWorlds            = $this->server->worlds()->count();
        $rarityTotals           = $this->server->getWorldsRarityTotals();
        $possibleWorldAvailable = false;
        $worldsAllowed          = [];
        foreach ($this->worldRarityIds as $rarityId) {
            $rareData       = Rarity::find($rarityId);
            $percentMaximum = (int)$this->ratio[$rareData->title] ?? 0;
            if (empty($rarityTotals[$rarityId])) {
                $rarityPercentage = 0;
            } else {
                $rarityPercentage = floor(($rarityTotals[$rarityId]['total'] / $totalWorlds) * 100);
            }
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

        return $worldsAllowed;
    }

    private function getWorldTypes() {
        $return = [];
        foreach (WorldTypes::all() as $type) {
            $return[$type->id] = $type->title;
        }

        return $return;
    }
}
