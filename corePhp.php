<?php
//include "vendor/eftec/bladeone/lib/BladeOne.php";
//use eftec\bladeone;

//$views = __DIR__ . '/views'; // folder where is located the templates
//$compiledFolder = __DIR__ . '/compiled';
//$blade=new bladeone\BladeOne($views,$compiledFolder);
//echo $blade->run("Test.hello", ["name" => "hola mundo"]);



function addRequiredPages($tablesRequired) {
    foreach($tablesRequired as $table) {
        require_once($table.'.php');
    }
}
function readTable($table)
{
    switch($table) {
        case 'ores' :
            $return  = new ores();
            $return->read('ores');
            break;
        case 'ingots' :
            $return  = new ingots();
            $return->read('ingots');
            break;
        case 'components' :
            $return  = new components();
            $return->read('components');
            break;
        case 'servers' :
            $return  = new servers();
            $return->read('servers');
            break;
        case 'stations' :
            $return  = new stations();
            $return->read('stations');
            break;
        case 'tradeZones' :
            $return  = new tradeZones();
            $return->read('trade_zones');
            break;
        default :
            $return = null;
    }

    return $return;
}