<?php namespace Colonization;

require_once('db/dbClass.php');
use DB\dbClass;

//include "vendor/eftec/bladeone/lib/BladeOne.php";
//use eftec\bladeone;

//$views = __DIR__ . '/views'; // folder where is located the templates
//$compiledFolder = __DIR__ . '/compiled';
//$blade=new bladeone\BladeOne($views,$compiledFolder);
//echo $blade->run("Test.hello", ["name" => "hola mundo"]);

class corePHP
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
    
    function ddng($var)
    {
        ini_set("highlight.keyword", "#a50000;  font-weight: bolder");
        ini_set("highlight.string", "#5825b6; font-weight: lighter; ");
        
        ob_start();
        highlight_string("<?php\n" . var_export($var, true) . "?>");
        $highlighted_output = ob_get_clean();
        
        $highlighted_output = str_replace(["&lt;?php", "?&gt;"], '', $highlighted_output);
        
        echo $highlighted_output;
        die();
    }
}