<?php
require "vendor/autoload.php";

use Colonization\CorePHP;
use Core\MagicNumbers;
use Core\Clusters;

$magicNumbers   = new MagicNumbers();
$cluster        = new Clusters();
$corePhp        = new CorePHP();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spreadsheet</title>
    <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link href="public/css/default.css" type="text/css" rel="stylesheet">
    <script src="public/js/default.js"></script>

</head>
<body>
<?php require_once('menubar.php'); ?>
<article class="tabs">
    <section id="magicNumbers" class="simpleDisplay">
        <h2><a class="headerTitle" href="#magicNumbers">Magic Numbers</a></h2>
        <div class="tab-content">

            <h3>Single Magic Variables</h3>
            <h4>Universal Constants</h4>
            <table>
                <thead>
                <tr>
                    <th>Receipt base effeciency</th>
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
                    <td><?=$magicNumbers->getBaseEfficiency()*100;?>%</td>
                    <td><?=$magicNumbers->getBaseMultiplierForBuyVsSell()*100;?>%</td>
                    <td><?=$magicNumbers->getBaseRefineryKWh();?></td>
                    <td><?=$magicNumbers->getCostPerKWh();?></td>
                    <td><?=$magicNumbers->getBaseRefinerySpeed()*100;?>%</td>
                    <td><?=$magicNumbers->getBaseLaborPerHour();?></td>
                    <td><?=$magicNumbers->getDrillKWPerHour();?></td>
                    <td><?=$magicNumbers->getOreGatherCost();?></td>
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
                    <th>Foundational (<?= $cluster->foundationOreData->title;?>) Ore base value</th>
                    <th>Modifier to Stone Value</th>
                    <th>Total Systems in Cluster</th>
                    <th>Base asteroid scarcity modifier</th>
                    <th>Base planet scarcity modifier</th>
                    <th>Server base multiplier</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th><?=$magicNumbers->getWeightForSystemStock();?></th>
                    <th><?=$cluster->getTotalServers()*10;?></th>
                    <th><?=$cluster->getScalingModifier();?></th>
                    <th><?=$cluster->getFoundationalOreValue();?></th>
                    <th><?=$cluster->getStoneModifier();?></th>
                    <th><?=$cluster->getTotalServers();?></th>
                    <th><?=$cluster->getAsteroidScarcityModifier();?></th>
                    <th><?=$cluster->getPlanetScarcityModifier();?></th>
                    <th><?=$cluster->getBaseModifier();?></th>
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
                    <th>Max eff mods</th>
                    <?php foreach($cluster->getServers() as $server) : ?>
                        <th><?=$server->getName();?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cluster->getOres() as $ore) : ?>
                    <tr>
                        <td><?=$ore->getName();?></td>
                        <td><?=$ore->getBaseProcessingTimePerOre();?></td>
                        <td><?=$ore->getBaseConversionEfficiency();?></td>
                        <td><?=$ore->getMaxEfficiencyWithModules();?></td>
                        <?php foreach($cluster->getServers() as $server) : ?>
                            <?php $hasOre = (in_array($ore->id, $server->getOreIds()));?>
                            <td class="<?=($hasOre) ? 'hasOre' : '';?>"><?= ($hasOre) ? "1" : "0"; ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php foreach(['ores','ingots','components'] as $table) :
        $$table = $corePhp->readTable($table);
        ?>
        <section id="<?=$table;?>" class="simpleDisplay">
            <h2><a class="headerTitle" href="#<?=$table;?>"><?=$table;?></a></h2>
            <div class="tab-content">
                <table>
                    <thead>
                    <tr>
                        <?php foreach($$table['headers'] as $header) : ?>
                            <th><?=$header; ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($$table['rows'] as $data) : ?>
                        <tr>
                            <?php foreach($data as $row) : ?>
                                <td><?= $row; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endforeach; ?>
    <section id="generalValues" class="simpleDisplay">
        <h2><a class="headerTitle" href="#generalValues">General Values</a></h2>
        <div class="tab-content">
            <h3>Ores</h3>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Base Value</th>
                    <th>Base Value + Scarcity</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($cluster->getOres() as $ore) : ?>
                    <tr>
                        <td><?=$ore->getName();?></td>
                        <td><?=$ore->getBaseValue();?></td>
                        <td><?=$ore->getScarcityAdjustedValue();?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Ingots</h3>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Base Value</th>
                    <th>Base Value + Scarcity</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cluster->getIngots() as $ingot) : ?>
                    <tr>
                        <td><?=$ingot->getName();?></td>
                        <td><?=$ingot->getBaseValue();?></td>
                        <td><?=$ingot->getScarcityAdjustedValue();?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
          <h3>Components</h3>
          <table>
            <thead>
            <tr>
              <th>Name</th>
              <th>Base Value</th>
              <th>Base Value + Scarcity</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cluster->getComponents() as $component) : ?>
              <tr>
                <td><?=$component->getName();?></td>
                <td><?=$component->getBaseValue();?></td>
                <td><?=$component->getScarcityAdjustedValue();?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
    </section>
    <section id="systemValues" class="simpleDisplay">
        <h2><a class="headerTitle" href="#systemValues">System Values</a></h2>
        <h3>ORE</h3>
        <div class="tab-content">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Goal</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($cluster->getOres() as $ore) : ?>
                    <tr>
                        <td><?= $ore->getName(); ?></td>
                        <td><?= $ore->getSystemStock(); ?></td>
                        <td><?= $ore->getSystemStockGoal(); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</article>
</body>
</html>