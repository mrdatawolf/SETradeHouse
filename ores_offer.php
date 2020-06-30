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
$ores           = $cluster->ores()->get();
$ingots         = $cluster->ingots()->get();
$economyOre     = $cluster->economyOre;
$totalServers   = $servers->count();
$components     = Components::all();
$defaultAmount  = 1000;
$defaultMultiplier  = 1.1;
?>

<script src="public/js/to_csv.js"></script>
<script src="public/js/offer_order.js"></script>
<table style="margin-top: 5em;" class="table table-bordered">
  <caption>
    <button onclick="exportTableToCSV('offer_ores.csv', false)">Export HTML Table To CSV File</button> | <button onclick="exportTableToDIV(false)">Show CSV Data</button> || <label for="set_amount">Amount: </label><input id="set_amount" name="set_amount" type="text" value="<?=$defaultAmount;?>"> <label for="set_modifier">Base Value Modifier: </label><input name="set_modifier" type="text" value="<?=$defaultMultiplier;?>">
  </caption>
    <thead>
    <tr>
      <th>Item</th>
      <th>Store Type</th>
      <th>Price Per</th>
      <th>Amount for sale</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($ores as $ore) {
      if($ore->se_name !== 'fillme') {
        $value = $ore->getStoreAdjustedValue();
        if($value > 0 && $defaultMultiplier > 0) {
        ?>
          <tr>
            <td><?=$ore->se_name;?></td>
            <td>Offer</td>
            <td><span class="editable"><?=round($ore->getStoreAdjustedValue())*$defaultMultiplier;?></span></td>
            <td><span class="editable amount"><?=$defaultAmount;?></span></td>
          </tr>
        <?php
        }
      }
    }
    ?>
    </tbody>
</table><br>
<div id="userData">
  <h4>CSV Data</h4>
  <textbox id="csv_text">
</div>
<?php require_once('end.php'); ?>

