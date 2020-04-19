<?php
$title = 'Spreadsheet';
require 'start.php';
use Controllers\MagicNumbers;
use Models\Clusters as ClusterModel;
use Models\Components;

$magic      = new MagicNumbers();
$magicData  = $magic->basicData();
$cluster    = ClusterModel::with('servers', 'ores', 'economyOre', 'ingots')->find($clusterId);

$servers        = $cluster->servers()->with('tradezones')->get();
$ores           = $cluster->ores()->get();
$ingots         = $cluster->ingots()->get();

$economyOre     = $cluster->economyOre;
$totalServers   = $servers->count();
$components     = Components::all();

?>
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
        <h2><a class="headerTitle" href="#serverValues">Cluster Values</a></h2>
        <div class="tab-content">
            <table>
                <thead>
                <tr><th colspan="3">Ores</th> </tr>
                <tr>
                    <th>Name</th>
                    <th>Stock (Sells)</th>
                    <th>Goal (Buys)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $typeId = 1;
                  foreach($ores as $ore) :
                    ?>
                    <tr>
                        <td><?= $ore->title; ?></td>
                        <td><?= $cluster->getTotalSellOrders($typeId, $ore->id) ;?></td>
                        <td><?= $cluster->getTotalBuyOrders($typeId, $ore->id) ;?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <thead>
                <tr><th colspan="3">Ingots</th> </tr>
                <tr>
                  <th>Name</th>
                  <th>Stock (Sells)</th>
                  <th>Goal (Buys)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $typeId = 2;
                foreach($ingots as $ingot) :
                    ?>
                  <tr>
                    <td><?= $ingot->title; ?></td>
                    <td><?= $cluster->getTotalSellOrders($typeId, $ingot->id) ;?></td>
                    <td><?= $cluster->getTotalBuyOrders($typeId, $ingot->id) ;?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              <thead>
              <tr><th colspan="3">Components</th> </tr>
              <tr>
                <th>Name</th>
                <th>Stock (Sells)</th>
                <th>Goal (Buys)</th>
              </tr>
              </thead>
              <tbody>
              <?php
              $typeId = 3;
              foreach($components as $component) :
                  ?>
                <tr>
                  <td><?= $component->title; ?></td>
                  <td><?= $cluster->getTotalSellOrders($typeId, $component->id) ;?></td>
                  <td><?= $cluster->getTotalBuyOrders($typeId, $component->id) ;?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
        </div>
    </section>
    <?php //variables
    $specialHeaders = ["Name" => 1 ,"Trade Zone Data" => 5,"Server Data" => 5,"Cluster Data" => 5];
    $baseHeaders    = ["Name","Desire","Avg SC per Order","Orders Worth","Scarcity SC Per Order","Scarcity Worth","Desire","Avg SC per Order","Orders Worth","Scarcity SC Per Order","Scarcity Worth","Desire","Avg SC per Order","Orders Worth","Scarcity SC Per Order","Scarcity Worth"];
    foreach($servers as $server) :
        foreach ($server->tradezones as $tradezone) :
        ?>
        <section id="<?=$tradezone->title;?>Trade" class="simpleDisplay">
            <h2><a class="headerTitle" href="#<?=$tradezone->title;?>Trade"><?=$tradezone->title;?></a></h2>
            <div class="tab-content">
                <table>
                    <thead>
                    <tr><th colspan="16">Ores</th> </tr>
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
                    <?php $typeId = 1;?>
                    <?php foreach($ores as $ore) : ?>
                        <tr>
                          <td><?=$ore->title;?></td>
                          <td><?=number_format($tradezone->getDesire($clusterId, $typeId, $ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->listedValue($clusterId, $typeId, $ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->getDesire($clusterId, $typeId, $ore->id)*$tradezone->listedValue($clusterId, $typeId,$ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($ore->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->getDesire($clusterId, $typeId, $ore->id)*$ore->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><?=number_format($server->getDesire($typeId, $ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->listedValue($typeId, $ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->getDesire($typeId, $ore->id)*$server->listedValue($typeId,$ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($ore->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->getDesire($typeId, $ore->id)*$ore->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><?=number_format($cluster->getDesire($typeId, $ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->listedValue($typeId, $ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->getDesire($typeId, $ore->id)*$cluster->listedValue($typeId,$ore->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($ore->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->getDesire($typeId, $ore->id)*$ore->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                        </tr>
                    <?php endforeach; ?>
                    <thead>
                    <tr><th colspan="16">Ingots</th> </tr>
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
                    <?php $typeId = 2;?>
                    <?php foreach($ingots as $ingot) : ?>
                        <tr>
                          <td><?=$ingot->title;?></td>
                          <td><?=number_format($tradezone->getDesire($clusterId, $typeId, $ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->listedValue($clusterId, $typeId, $ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->getDesire($clusterId, $typeId, $ingot->id)*$tradezone->listedValue($clusterId, $typeId,$ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($ingot->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->getDesire($clusterId, $typeId, $ingot->id)*$ingot->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><?=number_format($server->getDesire($typeId, $ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->listedValue($typeId, $ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->getDesire($typeId, $ingot->id)*$server->listedValue($typeId,$ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($ingot->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->getDesire($typeId, $ingot->id)*$ingot->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><?=number_format($cluster->getDesire($typeId, $ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->listedValue($typeId, $ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->getDesire($typeId, $ingot->id)*$cluster->listedValue($typeId,$ingot->id),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($ingot->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                          <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->getDesire($typeId, $ingot->id)*$ingot->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                        </tr>
                    <?php endforeach; ?>
                    <thead>
                    <tr><th colspan="16">Components</th> </tr>
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
                  <?php $typeId = 3;?>
                  <?php foreach($components as $component) : ?>
                    <tr>
                      <td><?=$component->title;?></td>
                      <td><?=number_format($tradezone->getDesire($clusterId, $typeId, $component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->listedValue($clusterId, $typeId, $component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->getDesire($clusterId, $typeId, $component->id)*$tradezone->listedValue($clusterId, $typeId,$component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($component->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($tradezone->getDesire($clusterId, $typeId, $component->id)*$component->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                      <td><?=number_format($server->getDesire($typeId, $component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->listedValue($typeId, $component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->getDesire($typeId, $component->id)*$server->listedValue($typeId,$component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($component->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($server->getDesire($typeId, $component->id)*$component->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                      <td><?=number_format($cluster->getDesire($typeId, $component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->listedValue($typeId, $component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->getDesire($typeId, $component->id)*$cluster->listedValue($typeId,$component->id),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($component->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                      <td><i class="fa fa-bitcoin"></i>&nbsp;<?=number_format($cluster->getDesire($typeId, $component->id)*$component->getScarcityAdjustedValue($totalServers,$clusterId),0);?></td>
                    </tr>
                  <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php
        endforeach;
    endforeach;
        ?>
</article>
<?php
require_once ('end.php');
?>