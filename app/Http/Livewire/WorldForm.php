<?php namespace App\Http\Livewire;

use App\Http\Traits\worldInfo;
use Livewire\Component;
use App\Models\Worlds;

class WorldForm extends Component
{
    use worldInfo;

    public $title;
    public $serverId;
    public $typeId;
    public $systemStockWeight;
    public $shortName;
    public $rarityTypesAllowed;
    public $worldTypes;

    protected $rules = [
        'title'             => 'required',
        'serverId'          => 'required',
        'rarityTypesAllowed' => 'required',
        'systemStockWeight' => 'required',
        'shortName'         => 'required',
        'worldTypes'        => 'required'
    ];

    public function mount() {
        $this->rarityTypesAllowed = $this->getAllowedWorlds();
        $this->worldTypes = $this->getWorldTypes();;
        $this->systemStockWeight = 1;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveWorld()
    {
        $validatedData = $this->validate();

        switch($validatedData['rarityTypesAllowed']) {
            case 2 :
                $rarity = 2;
                break;
            case 3 :
            case 4 :
            case 5 :
                $rarity = 3;
                break;
            default:
                $rarity = 1;
        }
        $modifiedCreateData = [
            'title' => $validatedData['title'],
            'server_id' => $validatedData['serverId'],
            'type_id'   => $validatedData['worldTypes'],
            'system_stock_weight' => $validatedData['systemStockWeight'],
            'short_name' => $validatedData['shortName'],
            'rarity'    => $rarity
        ];
        dd($modifiedCreateData);
        Worlds::create($modifiedCreateData);

        return redirect()->to('/admin/worlds/create');
    }


    public function render()
    {
        info($this->worldTypes);
        return view('livewire.world-form');
    }
}
