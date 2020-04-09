<?php
require 'start.php';
?>

Setup tests for trades here.
<?php
$ore = \Models\Ores::with('Servers')->find(1);
foreach ($ore->servers as $serverClass ) {
    $server = $serverClass->with('cluster');
    ddng($server->cluster);

}
?>