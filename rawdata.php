<?php
$title="Raw Data";
require 'start.php';

use Controllers\Ores;
use Controllers\Ingots;
use Controllers\Components;
use Controllers\Servers;
use Controllers\Stations;
use Controllers\TradeZones;
use Controllers\Clusters;
use Controllers\MagicNumbers;
use Controllers\ServerTypes;
use Controllers\ActiveTransactions;
use Controllers\InactiveTransactions;

$tables = ['Ores', 'Ingots', 'Components', 'Servers', 'Stations', 'TradeZones', 'Clusters', 'MagicNumbers', 'ServerTypes', 'ActiveTransactions', 'InactiveTransactions'];

function read($table, $clusterId) {
    $headers = null;
    $rows = null;
  if($table === 'Ores') {
      $ores     = new Ores($clusterId);
      $headers  = $ores->headers();
      $rows     = $ores->rows();
  } elseif($table === 'Ingots') {
      $ingots   = new Ingots($clusterId);
      $headers  = $ingots->headers();
      $rows     = $ingots->rows();
  } elseif($table === 'Components') {
      $components   = new Components($clusterId);
      $headers      = $components->headers();
      $rows         = $components->rows();
  } elseif($table === 'Servers') {
      $servers  = new Servers($clusterId);
      $headers  = $servers->headers();
      $rows     = $servers->rows();
  } elseif($table === 'Stations') {
      $stations = new Stations();
      $headers  = $stations->headers();
      $rows     = $stations->rows();
  } elseif($table === 'TradeZones') {
      $tradeZones   = new TradeZones();
      $headers      = $tradeZones->headers();
      $rows         = $tradeZones->rows();
  } elseif($table === 'Clusters') {
      $clusters = new Clusters($clusterId);
      $headers  = $clusters->headers();
      $rows     = $clusters->rows();
  } elseif($table === 'MagicNumbers') {
      $magicNumbers = new MagicNumbers();
      $headers      = $magicNumbers->headers();
      $rows         = $magicNumbers->rows();
  } elseif($table === 'ServerTypes') {
      $systemTypes  = new ServerTypes();
      $headers      = $systemTypes->headers();
      $rows         = $systemTypes->rows();
  } elseif($table === 'ActiveTransactions') {
      $systemTypes  = new ActiveTransactions();
      $headers      = $systemTypes->headers();
      $rows         = $systemTypes->rows();
  } elseif($table === 'InactiveTransactions') {
      $systemTypes  = new InactiveTransactions();
      $headers      = $systemTypes->headers();
      $rows         = $systemTypes->rows();
  }

  return ['headers' => $headers, 'rows' => $rows];
}
?>
<style>
  #rawdataLink {
    background-color: #DDE9FF;
  }
</style>
<article class="tabs">
    <?php foreach($tables as $table) :
        $tableData = read($table, $thisCluster->id);
        ?>
      <section id="<?=$table;?>" class="simpleDisplay">
          <?php
          if($table === 'ActiveTransactions') {
              $titletable = 'ActiveTrans';
          } elseif($table === 'InactiveTransactions') {
              $titletable = 'InactiveTrans';
          }
          else {
              $titletable = $table;
          }
          ?>
        <h2><a class="headerTitle" href="#<?=$table;?>"><?=$titletable;?></a></h2>
        <div class="tab-content">
          <table>
            <thead>
            <tr>
                <?php foreach($tableData['headers'] as $header) : ?>
                  <th><?=$header; ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach($tableData['rows'] as $data) : ?>
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
</article>
<?php
require_once ('end.php');
?>