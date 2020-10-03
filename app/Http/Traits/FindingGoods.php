<?php namespace App\Http\Traits;

use App\Models\Components;
use App\Models\GoodTypes;
use App\Models\Ingots;
use App\Models\Ores;
use App\Models\Tools;
use App\Models\TransactionTypes;

trait FindingGoods {
    /**
     * note: normally you want the good from the seName... this returns it for you.
     * @param $seName
     *
     * @return mixed
     */
    public function seNameToGood($seName) {
        $goodType = $this->seNameToGoodType($seName);

        return $this->seNameAndGoodTypeToGood($goodType, $seName);
    }


    /**
     * @param $seName
     *
     * @return string
     */
    public function seNameGroupToGoodTypeTitle($seName) {
        $seNameArray = explode('/',$seName);
        $seGoodType = $seNameArray[0];
        switch($seGoodType) {
            case 'MyObjectBuilder_Ingot' :
                $itemType = 'Ingot';
                break;
            case 'MyObjectBuilder_Ore' :
                $itemType = 'Ore';
                break;
            case 'MyObjectBuilder_Component':
                $itemType = 'Component';
                break;
            default:
                    /* tools should be things like :  'MyObjectBuilder_AmmoMagazine','MyObjectBuilder_ConsumableItem','MyObjectBuilder_GasContainerObject','MyObjectBuilder_OxygenContainerObject','MyObjectBuilder_PhysicalGunObject','MyObjectBuilder_Datapad','MyObjectBuilder_PhysicalObject','MyObjectBuilder_Package'*/
                $itemType = 'Tool';

        }

        return $itemType;
    }


    /**
     * @param $goodSeName
     *
     * @return mixed
     */
    public function seNameToGoodType($goodSeName) {
        $seNameArray = explode('/',$goodSeName);
        $goodType = $this->seNameGroupToGoodTypeTitle($seNameArray[0]);


        return GoodTypes::where('title',$goodType)->first();
    }

    /**
     * @param $goodType
     * @param $seName
     *
     * @return string
     */
    private function seNameToGoodTitle($goodType, $seName) {
        switch($goodType->id) {
            case '2' :
                $name = Ingots::where('se_name', $seName)->pluck('title')->first();
                break;
            case '1' :
                $name = Ores::where('se_name', $seName)->pluck('title')->first();
                break;
            case '3' :
                $name = Components::where('se_name', $seName)->pluck('title')->first();
                break;
            default:
                $name = Tools::where('se_name', $seName)->pluck('title')->first();

        }

        return $name ?? '';
    }


    /**
     * @param $goodType
     * @param $seName
     *
     * @return mixed
     */
    private function seNameAndGoodTypeToGood($goodType, $seName) {
        switch($goodType->id) {
            case '1' :
                $model = Ores::where('se_name', $seName)->first();
                break;
            case '2' :
                $model = Ingots::where('se_name', $seName)->first();
                break;
            case '3' :
                $model = Components::where('se_name', $seName)->first();
                break;
            default:
                $model = Tools::where('se_name', $seName)->first();
        }

        return $model;
    }

    public function getGoodFromIds($typeId, $goodId) {

    }

    /**
     * @param $goodType
     * @param $goodId
     *
     * @return |null
     */
    private function getGoodFromGoodTypeAndGoodId($goodType, $goodId) {
        switch($goodType->id) {
            case '2' :
                $model = Ingots::find($goodId);
                break;
            case '1' :
                $model = Ores::find($goodId);
                break;
            case '3' :
                $model = Components::find($goodId);
                break;
            default:
                $model = Tools::find($goodId);

        }

        return (! empty($model)) ? $model : null;
    }


    /**
     * @param $goodType
     * @param $goodTitle
     *
     * @return Ingots|Ores|Components|Tools|null
     */
    private function getGoodFromGoodTypeAndGoodTitle($goodType, $goodTitle) {
        switch($goodType->id) {
            case '2' :
                $model = Ingots::where('title',$goodTitle)->first();
                break;
            case '1' :
                $model = Ores::where('title',$goodTitle)->first();
                break;
            case '3' :
                $model = Components::where('title',$goodTitle)->first();
                break;
            default:
                $model = Tools::where('title',$goodTitle)->first();

        }

        return (! empty($model)) ? $model : null;
    }


    /**
     * @param $typeId
     *
     * @return mixed
     */
    private function getTransactionTypeFromId($typeId) {
        return TransactionTypes::find($typeId);
    }

}
