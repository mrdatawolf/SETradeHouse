<?php

$title = 'Build Offer for Components';
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
$defaultAmount      = 1000;
$defaultMultiplier  = 1.1;
?>

<script src="public/js/to_csv.js"></script>
<table style="margin-top: 5em;" class="table table-bordered">
  <caption>
    <button onclick="exportTableToCSV('offer.csv')">Export HTML Table To CSV File</button> || <label for="set_amount">Amount: </label><input id="set_amount" name="set_amount" type="text" value="1000"> <label for="set_modifier">Base Value Modifier: </label><input id="set_modifier" name="set_modifier" type="text" value="1.1" readonly>
  </caption>
    <thead>
    <tr>
      <th>Item</th>
      <th>Store Type</th>
      <th>Amount for sale</th>
      <th>Price Per</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($components as $component) {
      if(! in_array($component->title, $tools)){
        ?>
          <tr>
            <td><?=$component->se_name;?></td>
            <td>Offer</td>
            <td class="amount"><?=$defaultAmount;?></td>
            <td><?=round($component->getStoreAdjustedValue()*$defaultMultiplier);?></td>

          </tr>
        <?php
      }
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

