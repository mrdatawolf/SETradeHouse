<?php namespace App\Http\Traits;

use App\Components;
use App\GoodTypes;
use App\Ingots;
use App\Ores;
use App\Tools;
use App\TransactionTypes;

trait CheckNames {
    public function seNameToGroupType($item) {
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
                    /* tools should be things like
                     * 'MyObjectBuilder_AmmoMagazine','MyObjectBuilder_ConsumableItem','MyObjectBuilder_GasContainerObject','MyObjectBuilder_OxygenContainerObject','MyObjectBuilder_PhysicalGunObject','MyObjectBuilder_Datapad','MyObjectBuilder_PhysicalObject','MyObjectBuilder_Package'
                    */
                $itemType = 'Tools';

        }

        return $itemType;
    }

    public function seNameToGroup($item) {
        $itemArray = explode('/',$item);
        $itemType = $this->seNameToGroupType($itemArray[0]);

        return GoodTypes::where('title',$itemType)->first();
    }

    /**
     * @param $group
     * @param $item
     *
     * @return string
     */
    private function seNameToItemTitle($group, $item) {
        switch($group->id) {
            case '2' :
                $name = Ingots::where('se_name', $item)->pluck('title')->first();
                break;
            case '1' :
                $name = Ores::where('se_name', $item)->pluck('title')->first();
                break;
            case '3' :
                $name = Components::where('se_name', $item)->pluck('title')->first();
                break;
            default:
                $name = Tools::where('se_name', $item)->pluck('title')->first();

        }

        return $name ?? '';
    }


    private function seNameToItem($group, $item) {
        switch($group->id) {
            case '2' :
                $model = Ingots::where('se_name', $item)->first();
                break;
            case '1' :
                $model = Ores::where('se_name', $item)->first();
                break;
            case '3' :
                $model = Components::where('se_name', $item)->first();
                break;
            default:
                $model = Tools::where('se_name', $item)->first();
        }

        return $model;
    }

    private function getItemFromGroupAndItemId($group, $itemId) {
        switch($group->id) {
            case '2' :
                $model = Ingots::find($itemId);
                break;
            case '1' :
                $model = Ores::find($itemId);
                break;
            case '3' :
                $model = Components::find($itemId);
                break;
            default:
                $model = Tools::find($itemId);

        }

        return (! empty($model)) ? $model : null;
    }

    private function getTransactionTypeFromId($typeId) {
        return TransactionTypes::find($typeId);
    }

}
