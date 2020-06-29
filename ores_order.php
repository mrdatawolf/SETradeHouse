<?php

$title = 'Build Ores Order';
require 'start.php';

use Controllers\MagicNumbers;
use Models\Clusters as ClusterModel;
use Models\Components;

$magic              = new MagicNumbers();
$magicData          = $magic->basicData();
$cluster            = ClusterModel::with('servers', 'ores', 'economyOre', 'ingots')->find($thisCluster->id);
$servers            = $cluster->servers()->with('tradezones')->get();
$ores               = $cluster->ores()->get();
$ingots             = $cluster->ingots()->get();
$economyOre         = $cluster->economyOre;
$totalServers       = $servers->count();
$components         = Components::all();
$defaultAmount      = 1000000;
$defaultMultiplier  = 1;
?>

  <script src="public/js/to_csv.js"></script>
<table style="margin-top: 5em;" class="table table-bordered">
  <caption>
    <button onclick="exportTableToCSV('order.csv')">Export HTML Table To CSV File</button> || <label for="set_amount">Amount: </label><input id="set_amount" name="set_amount" type="text" value="<?=$defaultAmount;?>"> <label for="set_modifier">Base Value Modifier: </label><input name="set_modifier" type="text" value="<?=$defaultMultiplier;?>">
  </caption>
    <thead>
    <tr>
        <th>Item</th>
        <th>Amount desired</th>
        <th>Price Per</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($ores as $ore) {
    ?>
        <tr>
          <td><?=$ore->se_name;?></td>
          <td class="amount"><?=$defaultAmount;?></td>
          <td><?=round($ore->getStoreAdjustedValue()*$defaultMultiplier);?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<script>
  $('#set_amount').change( function() {
      $('.amount').html($(this).val());
  });
</script>

<?php require_once('end.php'); ?>