<?php namespace Colonization;

use Core\ores;
use Core\ingots;
use Core\components;
use Core\servers;
use Core\stations;
use Core\tradeZones;

//include "vendor/eftec/bladeone/lib/BladeOne.php";
//use eftec\bladeone;

//$views = __DIR__ . '/views'; // folder where is located the templates
//$compiledFolder = __DIR__ . '/compiled';
//$blade=new bladeone\BladeOne($views,$compiledFolder);
//echo $blade->run("Test.hello", ["name" => "hola mundo"]);

class corePHP
{
    function readTable($table)
    {
        switch ($table) {
            case 'ores' :
                $return = new ores();
                $return->read('ores');
                break;
            case 'ingots' :
                $return = new ingots();
                $return->read('ingots');
                break;
            case 'components' :
                $return = new components();
                $return->read('components');
                break;
            case 'servers' :
                $return = new servers();
                $return->read('servers');
                break;
            case 'stations' :
                $return = new stations();
                $return->read('stations');
                break;
            case 'tradeZones' :
                $return = new tradeZones();
                $return->read('trade_zones');
                break;
            default :
                $return = new Ma;
        }
        
        return $return;
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