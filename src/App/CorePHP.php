<?php namespace Colonization;

class CorePHP
{
    function getTableName($title)
    {
        switch ($title) {
            case 'tradeZones' :
                $table = 'trade_zones';
                break;
            case 'systemTypes' :
                $table = 'system_types';
                break;
            case 'ingotOres' :
            case 'ingotsOres':
                $table = 'ingots_ores';
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
            case 'magicNumbers' :
                $table = 'magic_numbers';
                break;
            default :
                $table = $title;
        }

        return $table;
    }
}