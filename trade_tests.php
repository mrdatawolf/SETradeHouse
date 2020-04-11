<?php
require 'start.php';
?>

Setup tests for trades here.
<?php
$ore = \Models\Ores::with('Servers')->find(1);
$totalServers = \Models\Servers::where('cluster_id', 2)->count();
$servers = [];
foreach ($ore->servers as $serverClass ) {
  if($serverClass->cluster_id == 2) {
    $servers[] = $serverClass;
  }
}
$totalServerWithOre = count($servers);
ddng($ore->getScarcityAdjustment($totalServers, $totalServerWithOre, 0));

?>