<?php namespace App\Http\Traits;

use App\Models\Ammo;
use App\Models\Bottles;
use App\Models\Components;
use App\Models\GoodTypes;
use App\Models\Ingots;
use App\Models\Ores;
use App\Models\Tools;
use App\Models\TransactionTypes;

trait FindingGoods {
    private $specialGoods = [
        'WelderItem',
        'Welder2Item',
        'Welder3Item',
        'Welder4Item',
        'AngleGrinderItem',
        'AngleGrinder2Item',
        'AngleGrinder3Item',
        'AngleGrinder4Item',
        'HandDrillItem',
        'HandDrill2Item',
        'HandDrill3Item',
        'HandDrill4Item',
        'AutomaticRifleItem',
        'RapidFireAutomaticRifleItem',
        'PreciseAutomaticRifleItem',
        'UltimateAutomaticRifleItem'
    ];

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
     * @param $seNameGroup
     * @param $seName
     *
     * @return string
     */
    public function seNameGroupToGoodTypeTitle($seNameGroup, $seName) {
        $seNameArray = explode('/',$seNameGroup);
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
            case 'MyObjectBuilder_AmmoMagazine':
            case 'MyObjectBuilder_PhysicalGunObject':
                if(empty($seName)) {
                    dd($seNameArray, $seGoodType);
                }
                $itemType = (in_array($seName, $this->specialGoods)) ? 'Tool' : 'Ammo';
                break;
            case 'MyObjectBuilder_GasContainerObject' :
            case 'MyObjectBuilder_OxygenContainerObject' :
                $itemType = 'Bottle';
                break;
            default:
                    /* tools should be things like :  'MyObjectBuilder_ConsumableItem','MyObjectBuilder_PhysicalGunObject','MyObjectBuilder_Datapad','MyObjectBuilder_PhysicalObject','MyObjectBuilder_Package'*/
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
        $goodType = $this->seNameGroupToGoodTypeTitle($seNameArray[0], $seNameArray[1]);
        if(empty($goodType)) {
            dd($seNameArray);
        }

        return GoodTypes::where('api_name',$goodType)->first();
    }


    public function getGoodTypeId($goodTypeName) {
        switch($goodTypeName) {
            case 'Ingot':
                return '2';
            case 'Ore':
                return '1';
            case 'Component':
                return '3';
            case 'Ammo':
                return '5';
            case 'Bottle':
                return '6';
            default:
                return '4';
        }
    }


    public function getGoodFromGoodtypeIdAndGoodId($goodTypeId, $goodId) {
        switch($goodTypeId) {
            case '2' :
                $model = Ingots::find($goodId);
                break;
            case '1' :
                $model = Ores::find($goodId);
                break;
            case '3' :
                $model = Components::find($goodId);
                break;
            case '4' :
                $model = Tools::find($goodId);
                break;
            case '5' :
                $model = Ammo::find($goodId);
                break;
            case '6' :
                $model = Bottles::find($goodId);
                break;
            default:
                $model = Tools::find($goodId);

        }

        return (! empty($model)) ? $model : null;
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
            case '4' :
                $name = Tools::where('se_name', $seName)->pluck('title')->first();
                break;
            case '5' :
                $name = Ammo::where('se_name', $seName)->pluck('title')->first();
                break;
            case '6' :
                $name = Bottles::where('se_name', $seName)->pluck('title')->first();
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
        $seName = $this->correctSeNameIssues($seName);
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
            case '4' :
                $model = Tools::where('se_name', $seName)->first();
                break;
            case '5' :
                $model = Ammo::where('se_name', $seName)->first();
                break;
            case '6' :
                $model = Bottles::where('se_name', $seName)->first();
                break;
            default:
                $model = Tools::where('se_name', $seName)->first();
        }

        return $model;
    }

    private function correctSeNameIssues($seName) {
        switch($seName) {
            case 'MyObjectBuilder_PhysicalGunObject/AutomaticRifleItem':
                $seName = 'MyObjectBuilder_PhysicalGunObject/AutomaticRifle';
                break;
            case 'MyObjectBuilder_PhysicalGunObject/RapidFireAutomaticRifleItem':
                $seName = 'MyObjectBuilder_PhysicalGunObject/RapidFireAutomaticRifle';
                break;
            case 'MyObjectBuilder_PhysicalGunObject/PreciseAutomaticRifleItem':
                $seName = 'MyObjectBuilder_PhysicalGunObject/PreciseAutomaticRifle';
                break;
            case 'MyObjectBuilder_PhysicalGunObject/UltimateAutomaticRifleItem':
                $seName = 'MyObjectBuilder_PhysicalGunObject/UltimateAutomaticRifle';
                break;
            case 'MyObjectBuilder_AmmoMagazine/NATO_25x184mmMagazine':
                $seName = 'MyObjectBuilder_AmmoMagazine/NATO_25x184mm';
                break;
            case 'MyObjectBuilder_PhysicalGunObject/NATO_5p56x45mmMagazine':
                $seName = 'MyObjectBuilder_AmmoMagazine/NATO_5p56x45mm';
                break;
            case 'MyObjectBuilder_PhysicalGunObject/Missile200mmMagazine':
                $seName = 'MyObjectBuilder_AmmoMagazine/Missile200mm';
        }
        return $seName;
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
            case '4' :
                $model = Tools::find($goodId);
                break;
            case '5' :
                $model = Ammo::find($goodId);
                break;
            case '6' :
                $model = Bottles::find($goodId);
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
                $model = Ingots::where('title',strtolower($goodTitle))->first();
                break;
            case '1' :
                $model = Ores::where('title',strtolower($goodTitle))->first();
                break;
            case '3' :
                $model = Components::where('api_name',$goodTitle)->first();
                break;
            case '4' :
                $model = Tools::where('api_name',$goodTitle)->first();
                break;
            case '5' :
                $model = Ammo::where('api_name',$goodTitle)->first();
                break;
            case '6' :
                $model = Bottles::where('api_name',$goodTitle)->first();
                break;
            default:
                $model = Tools::where('api_name',$goodTitle)->first();

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
