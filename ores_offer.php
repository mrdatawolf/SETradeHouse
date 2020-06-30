<?php

$title = 'Build Offer for Ores';
require 'start.php';

use Controllers\MagicNumbers;
use Models\Clusters as ClusterModel;
use Models\Components;

$magic          = new MagicNumbers();
$magicData      = $magic->basicData();
$cluster        = ClusterModel::with('servers', 'ores', 'economyOre', 'ingots')->find($thisCluster->id);
$servers        = $cluster->servers()->with('tradezones')->get();
$items          = $cluster->ores()->get();
$ingots         = $cluster->ingots()->get();
$economyOre     = $cluster->economyOre;
$totalServers   = $servers->count();
$components     = Components::all();
$defaultAmount  = 1000;
$defaultMultiplier  = 1.1;
?>
<div class="panel panel-default">
    <?php
    require_once './partials/builder_panel_heading.php';
    require_once './partials/builder_panel_body.php';
    require_once './partials/builder_panel_csv.php';
    ?>
</div>
<?php require_once('end.php'); ?>

