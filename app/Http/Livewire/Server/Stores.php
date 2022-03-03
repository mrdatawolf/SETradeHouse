<?php

namespace App\Http\Livewire\Server;

use App\Http\Traits\FindingGoods;
use App\Http\Traits\WorkWithTransactions;
use App\Models\GoodTypes;
use Livewire\Component;

class Stores extends Component
{
    use WorkWithTransactions, FindingGoods;

    public        $serverId = 1; //passed in
    public string $stores;
    public string $active   = 'active';
    public string $contentRows;
    public        $goodTypes;


    public function mount()
    {
        $this->goodTypes   = GoodTypes::pluck('title');
        $this->contentRows = json_encode($this->contentRows());
    }


    public function contentRows(): array
    {
        $stores         = $this->getTransactionsUsingTitles();
        $contentRows    = [];
        $specialClasses = 'show active';
        $active         = 'active';
        foreach ($stores as $name => $store) {
            $contentRows[]  = (object)[
                'gridName'       => $name,
                'active'         => $active,
                'SpecialClass'   => $specialClasses,
                'JSID'           => $store->jsid,
                'Owner'          => $store->owner,
                'NavigationRows' => $this->navigationRows($store),
                'GPS'            => $store->GPS,
                'GoodTypeRows'   => $this->goodTypeRows($store)
            ];
            $specialClasses = '';
            $active         = '';
        }

        return $contentRows;
    }


    public function navigationRows($store): array
    {
        $active         = 'active';
        $navigationData = [];
        foreach ($this->goodTypes as $goodType) {
            $navigationData[] = (object)['JSID' => $store->jsid, 'ActiveClass' => $active, 'GoodType' => $goodType];
            $active           = '';
        }

        return $navigationData;
    }


    public function goodTypeRows($store): array
    {
        $goodTypeRows   = [];
        $specialClasses = 'show active';
        foreach ($this->goodTypes as $goodType) {
            $goodTypeRows[] = (object)[
                'SpecialClasses' => $specialClasses,
                'JSID'           => $store->jsid,
                'GoodType'       => $goodType,
                'Goods'          => $store->goods
            ];
            $specialClasses = 'hide';
        }

        return $goodTypeRows;
    }


    public function render()
    {
        return view('livewire.worlds.stores');
    }
}
