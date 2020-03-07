<?php namespace Colonization;

use DB\dbClass;

//include "vendor/eftec/bladeone/lib/BladeOne.php";
//use eftec\bladeone;

//$views = __DIR__ . '/views'; // folder where is located the templates
//$compiledFolder = __DIR__ . '/compiled';
//$blade=new bladeone\BladeOne($views,$compiledFolder);
//echo $blade->run("Test.hello", ["name" => "hola mundo"]);

class CorePHP
{
    function readTable($title)
    {
        switch ($title) {
            case 'ores' :
                $table = 'ores';
                break;
            case 'ingots' :
                $table = 'ingots';
                break;
            case 'components' :
                $table = 'components';
                break;
            case 'servers' :
                $table = 'servers';
                break;
            case 'stations' :
                $table = 'stations';
                break;
            case 'tradeZones' :
                $table = 'trade_zones';
                break;
            case 'systemTypes' :
                $table = 'system_types';
                break;
            case 'ingotOres' :
                $table = 'ingot_ores';
                break;
            case 'oresServers' :
                $table = 'ores_servers';
                break;
            case 'oresStations' :
                $table = 'ores_stations';
                break;
            case 'serversLinks' :
                $table = 'servers_links';
                break;
            case 'serversSystemTypes' :
                $table = 'servers_systemtypes';
                break;
            default :
                $table = 'magic_numbers';
        }
        $dbClass = new dbClass();

        return $dbClass->read($table);
    }
    

}