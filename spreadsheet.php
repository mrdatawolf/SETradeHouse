<?php
$title = 'Spreadsheet';
require 'start.php';
use Controllers\MagicNumbers;
use Models\Clusters as ClusterModel;
use Models\Components;
use \Models\TradeZones;

$clusterId  = 2;
$magic      = new MagicNumbers();
$magicData  = $magic->basicData();

$cluster        = ClusterModel::with('servers', 'ores', 'economyOre', 'ingots')->find($clusterId);
$ores           = $cluster->ores()->get();
$ingots         = $cluster->ingots()->get();
$servers        = $cluster->servers()->get();
$economyOre     = $cluster->economyOre;
$totalServers   = $servers->count();
$components     = Components::all();

function getTotalTypeWithOre($serversWithOre, $clusterId, $typeId) {
    $totalWithOre = 0;
    foreach($serversWithOre->servers as $server) {
        if($server->clusters_id == $clusterId) {
            if ($server->types_id == $typeId) {
                $totalWithOre++;
            }
        }
    }

    return $totalWithOre;
}
?>
<style>
  #spreadsheetLink {
    background-color: #DDE9FF;
  }
</style>
<article class="tabs">
    <section id="magicNumbers" class="simpleDisplay">
        <h2><a class="headerTitle" href="#magicNumbers">Magic Numbers</a></h2>
        <div class="tab-content">

            <h3>Single Magic Variables</h3>
            <h4>Universal Constants</h4>
            <table>
                <thead>
                <tr>
                    <th>Receipt base efficiency</th>
                    <th>Base Multiplier for Buy vs Sell</th>
                    <th>base refinery kWh</th>
                    <th>Cost per kWh</th>
                    <th>Base refinery speed</th>
                    <th>Base Labor/h</th>
                    <th>Drill kWh</th>
                    <th>Ore gather and process markup</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?=$magicData->module_base_efficiency*100;?>%</td>
                    <td><?=$magicData->base_multiplier_for_buy_vs_sell*100;?>%</td>
                    <td><?=$magicData->base_refinery_kwh;?></td>
                    <td><?=$magicData->cost_kw_hour;?></td>
                    <td><?=$magicData->base_refinery_speed*100;?>%</td>
                    <td><?=$magicData->base_labor_per_hour;?></td>
                    <td><?=$magicData->base_drill_per_kw_hour;?></td>
                    <td><?=$magic->getOreGatherCost();?></td>
                </tr>
                </tbody>
            </table>
            <h4>Server/Cluster Variables</h4>
            <table>
                <thead>
                <tr>
                    <th>How much weight does the system stock have?</th>
                    <th>Number of Systems in cluster * 10</th>
                    <th>Scaling Modifier</th>
                    <th>Foundational (<?='platinum';?>) Ore base value</th>
                    <th>Modifier to Stone Value</th>
                    <th>Total Systems in Cluster</th>
                    <th>Base asteroid scarcity modifier</th>
                    <th>Base planet scarcity modifier</th>
                    <th>Server base multiplier</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th><?=$magicData->base_weight_for_system_stock;?></th>
                    <th><?=$totalServers*10;?></th>
                    <th><?=$cluster->scaling_modifier;?></th>
                    <th><?=$economyOre->getBaseValue();?></th>
                    <th><?=$cluster->economy_stone_modifier;?></th>
                    <th><?=$totalServers;?></th>
                    <th><?=$cluster->asteroid_scarcity_modifier;?></th>
                    <th><?=$cluster->planet_scarcity_modifier;?></th>
                    <th><?=$cluster->base_modifier;?></th>
                </tr>
                </tbody>
            </table>
            <h4>Grouped Magic Variables</h4>
            <table>
                <thead>
                <tr>
                    <th>Thing</th>
                    <th>Base processing time per ore</th>
                    <th>Base conversion efficiency</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($ores as $ore) : ?>
                    <tr>
                        <td><?=$ore->title;?></td>
                        <td><?=$ore->base_processing_time_per_ore;?></td>
                        <td><?=$ore->getOreEfficiency(0)*100;?>%</td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </section>
    <section id="ores" class="simpleDisplay">
      <h2><a class="headerTitle" href="#ores">Ores</a></h2>
      <div class="tab-content">
        <table>
          <thead>
          <tr>
                <th>Name</th>
                <th>Refinery Speed/Base time per ore</th>
                <th>kWh/Ore<br>Refinery kWh</th>
                <th>Ore per Ingot</th>
                <th>Ore per Ingot Max effec</th>
                <th>Base Value</th>
                <th>Store Adjusted</th>
                <th>Scarcity Adjusted Value</th>
                <th>Keen crap fix</th>
                <th>Scarcity Adjustment</th>
                <th>Base cost to gather 1 ore</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($ores as $ore) :
              $baseOrePerIngot          = $ore->getOreRequiredPerIngot(0);
          ?>
            <tr>
              <td><?=$ore->title;?></td>
              <td><?=$magicData->base_refinery_speed/$ore->base_processing_time_per_ore;?></td>
              <td><?=round($ore->getRefineryKiloWattHour($magicData->base_refinery_speed, $magicData->base_refinery_kwh),7);?></td>
              <td><?=round($baseOrePerIngot, 2);?></td>
              <td><?=$ore->getOreRequiredPerIngot(4);?></td>
              <td><?=$ore->getBaseValue();?></td>
              <td><?=round($ore->getStoreAdjustedValue());?></td>
              <td><?=round($ore->getScarcityAdjustedValue($totalServers, $clusterId));?></td>
              <td><?=$ore->keen_crap_fix;?></td>
              <td><?=$ore->getScarcityAdjustment($totalServers, $clusterId);?></td>
              <td><?=$ore->getBaseCostToGatherOre($economyOre, $cluster->scaling_modifier,1);?></td>
            </tr>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </section>
    <section id="ingots" class="simpleDisplay">
        <h2><a class="headerTitle" href="#ingots">Ingots</a></h2>
        <div class="tab-content">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>base effeciency * conversion efficiency * Ore processed per second</th>
                    <th>Base Value</th>
                    <th>Value with maximum eff modules</th>
                    <th>Store Adjusted Min</th>
                    <th>KEEEN!!!</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($ingots as $ingot) : ?>
                    <tr>
                        <td><?= $ingot->title;?></td>
                        <td><?=$ingot->getEfficiencyPerSecond($magicData->module_base_efficiency, $magicData->base_refinery_speed);?></td>
                        <td><?=$ingot->getBaseValue();?></td>
                        <td><?=$ingot->getBaseValue(4);?></td>
                        <td><?=$ingot->getStoreAdjustedValue();?></td>
                        <td><?=$ingot->keen_crap_fix;?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </section>
    <section id="components" class="simpleDisplay">
        <h2><a class="headerTitle" href="#components">components</a></h2>
        <div class="tab-content">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Cobalt Ingot</th>
                    <th>Gold Ingot</th>
                    <th>Iron Ingot</th>
                    <th>Magnesium Ingot</th>
                    <th>Nickel Ingot</th>
                    <th>Platinum Ingot</th>
                    <th>silicon Ingot</th>
                    <th>silver Ingot</th>
                    <th>gravel Ingot</th>
                    <th>uranium Ingot</th>
                    <th>Mass</th>
                    <th>Volume Ingot</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach($components as $row) : ?>
                    <tr>
                        <td><?= $row->title; ?></td>
                        <td><?= $row->cobalt/$cluster->base_modifier; ?></td>
                        <td><?= $row->gold/$cluster->base_modifier; ?></td>
                        <td><?= $row->iron/$cluster->base_modifier; ?></td>
                        <td><?= $row->magnesium/$cluster->base_modifier; ?></td>
                        <td><?= $row->nickel/$cluster->base_modifier; ?></td>
                        <td><?= $row->platinum/$cluster->base_modifier; ?></td>
                        <td><?= $row->silicon/$cluster->base_modifier; ?></td>
                        <td><?= $row->silver/$cluster->base_modifier; ?></td>
                        <td><?= $row->gravel/$cluster->base_modifier; ?></td>
                        <td><?= $row->uranium/$cluster->base_modifier; ?></td>
                        <td><?= $row->mass; ?></td>
                        <td><?= $row->volume; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <section id="generalValues" class="simpleDisplay">
        <h2><a class="headerTitle" href="#generalValues">General Values</a></h2>
        <div class="tab-content">
            <table>
                <thead>
                <tr><th colspan="3">Ore</th> </tr>
                <tr>
                    <th>Name</th>
                    <th>Store Adjusted</th>
                    <th>Store Adjusted  Scarcity</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($ores as $ore) :
                        $baseOrePerIngot          = $ore->getOreRequiredPerIngot(0);
                    ?>
                    <tr>
                        <td><?=$ore->title;?></td>
                        <td><?=round($ore->getStoreAdjustedValue());?></td>
                        <td><?=round($ore->getScarcityAdjustedValue($totalServers, $clusterId));?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <thead>
                <tr><th colspan="3">Ingots</th> </tr>
                <tr>
                    <th>Name</th>
                    <th>Store Adjusted</th>
                    <th>Store Adjusted with Scarcity</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($ingots as $ingot) :
                    $baseOrePerIngot    = $ingot->getOreRequiredPerIngot(0);
                ?>
                    <tr>
                        <td><?=$ingot->title;?></td>
                        <td><?=round($ingot->getStoreAdjustedValue());?></td>
                        <td><?=round($ingot->getScarcityAdjustedValue($totalServers, $clusterId));?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

                <thead>
                    <tr><th colspan="3">Components</th> </tr>
                    <tr>
                        <th>Name</th>
                        <th>Store Adjusted</th>
                        <th>Store Adjusted with Scarcity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($components as $component) : ?>
                    <tr>
                        <td><?=$component->title;?></td>
                        <td><?=round($component->getStoreAdjustedValue());?></td>
                        <td><?=round($component->getScarcityAdjustedValue($totalServers, $clusterId));?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <section id="serverValues" class="simpleDisplay">
        <h2><a class="headerTitle" href="#serverValues">Server Values</a></h2>
        <div class="tab-content">
            <table>
                <thead>
                <tr><th colspan="3">Ore</th> </tr>
                <tr>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Goal</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  foreach($ores as $ore) :
                    ?>
                    <tr>
                        <td><?= $ore->title; ?></td>
                        <td>fix me</td>
                        <td>fix me</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <thead>
                <tr><th colspan="3">Ingot</th> </tr>
                <tr>
                  <th>Name</th>
                  <th>Stock</th>
                  <th>Goal</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($ingots as $ingot) :
                    ?>
                  <tr>
                    <td><?= $ingot->title; ?></td>
                    <td>fix me</td>
                    <td>fix me</td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              <thead>
              <tr><th colspan="3">Component</th> </tr>
              <tr>
                <th>Name</th>
                <th>Stock</th>
                <th>Goal</th>
              </tr>
              </thead>
              <tbody>
              <?php
              foreach($components as $component) :
                  ?>
                <tr>
                  <td><?= $component->title; ?></td>
                  <td>fix me</td>
                  <td>fix me</td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </section>
    <?php //variables
    $specialHeaders = ["TZ Data" => 5,"System Data" => 3,"Goals" =>3];
    $baseHeaders = ["Name","Buy","Sell","SC Value per","Total Value","Base Value","Stock","Goal","TZ","System","Adjusted"];
    $tradezone = TradeZones::with('servers')->find(1);
    //ddng($tradezone->servers);
    ?>
    <section id="<?=$tradezone->title;?>Trade" class="simpleDisplay">
        <h2><a class="headerTitle" href="#<?=$tradezone->title;?>Trade"><?=$tradezone->title;?> Trade</a></h2>
        <div class="tab-content">
            <table>
                <thead>
                <tr><th colspan="12">Ore</th> </tr>
                <tr>
                    <?php foreach ($specialHeaders as $header => $span) : ?>
                        <th colspan="<?=$span;?>"><?=$header;?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($baseHeaders as $header) : ?>
                    <th><?=$header;?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($ores as $ore) : ?>
                    <tr>
                        <td><?=$ore->title;?></td>
                        <td><?=$tradezone->getTotalBuyOrders(1, $ore->id);?></td>
                        <td><?=$tradezone->getTotalSellOrders(1, $ore->id);?></td>
                        <td><?=round($ore->getScarcityAdjustedValue($totalServers,$clusterId),2);?></td>
                        <td><?=round(($tradezone->getTotalBuyOrders(1, $ore->id)- $tradezone->getTotalSellOrders(1, $ore->id))*$ore->getScarcityAdjustedValue($totalServers,$clusterId));?></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                <?php endforeach; ?>
                <tr><th colspan="11">Ingot</th> </tr>
                <tr>
                    <th colspan="5">TZ Data</th>
                    <th colspan="3">System Data</th>
                    <th colspan="3">Goals</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <th>Buy</th>
                    <th>Sell</th>
                    <th>Stock</th>
                    <th>Goal</th>
                    <th>Base Value</th>
                    <th>Stock</th>
                    <th>Goal</th>
                    <th>TZ</th>
                    <th>System</th>
                    <th>Adjusted</th>
                </tr>
                <?php foreach($ores as $thing) : ?>
                    <tr>
                        <td><?=$thing->title;?></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                <?php endforeach; ?>
                <tr><th colspan="11">Component</th> </tr>
                <tr>
                    <th colspan="5">TZ Data</th>
                    <th colspan="3">System Data</th>
                    <th colspan="3">Goals</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <th>Buy</th>
                    <th>Sell</th>
                    <th>Stock</th>
                    <th>Goal</th>
                    <th>Base Value</th>
                    <th>Stock</th>
                    <th>Goal</th>
                    <th>TZ</th>
                    <th>System</th>
                    <th>Adjusted</th>
                </tr>
                <?php foreach($components as $thing) : ?>
                    <tr>
                        <td><?=$thing->title;?></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</article>
<?php
require_once ('end.php');

?>
</body>
</html>