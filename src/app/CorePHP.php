<?php namespace Colonization;

use DB\dbClass;


class CorePHP
{
    function readTable($title)
    {
        switch ($title) {
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
            case 'magics' :
                $table = 'magic_numbers';
                break;
            default :
                $table = $title;
        }
        $dbClass = new dbClass();

        return $dbClass->read($table);
    }
    

}