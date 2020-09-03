<?php namespace App\Http\Traits;

use App\Components;
use App\Ingots;
use App\Ores;
use App\Tools;

trait CheckNames {
    public function seNameToGroup($item) {
        $itemArray = explode('/',$item);
        $seName = $itemArray[0];
        switch($seName) {
            case 'MyObjectBuilder_Ingot' :
                $itemType = 'Ingots';
                break;
            case 'MyObjectBuilder_Ore' :
                $itemType = 'Ores';
                break;
            case 'MyObjectBuilder_Component':
                $itemType = 'Components';
                break;
            default:
                $itemType = 'Tools';

        }

        return $itemType;
    }

    /**
     * @param $itemGroup
     * @param $item
     *
     * @return string
     */
    private function seNameToTitle($itemGroup, $item) {
        switch($itemGroup) {
            case 'Ingots' :
                $name = Ingots::where('se_name', $item)->pluck('title')->first();
                break;
            case 'Ores' :
                $name = Ores::where('se_name', $item)->pluck('title')->first();
                break;
            case 'Components' :
                $name = Components::where('se_name', $item)->pluck('title')->first();
                break;
            default:
                $name = Tools::where('se_name', $item)->pluck('title')->first();

        }

        return $name ?? '';
    }
}
