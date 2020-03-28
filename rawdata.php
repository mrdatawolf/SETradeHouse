<?php
require 'start.php';

use Controllers\Ores;
use Controllers\Ingots;
use Controllers\Components;
use Controllers\Servers;
use Controllers\Stations;
use Controllers\TradeZones;
use Controllers\Clusters;
use Controllers\MagicNumbers;
use Controllers\SystemTypes;

//$tablesRequired = ['ores','ingots','components','servers', 'stations', 'trade_zones', 'clusters', 'clusters_servers', 'magic_numbers', 'system_types', 'servers_links'];
$tables = ['Ores', 'Ingots', 'Components', 'Servers', 'Stations', 'TradeZones', 'Clusters', 'MagicNumbers', 'SystemTypes'];

function read($table) {
    $headers = null;
    $rows = null;
  if($table === 'Ores') {
      $headers  = Ores::headers();
      $rows     = Ores::rows();
  } elseif($table === 'Ingots') {
      $headers  = Ingots::headers();
      $rows     = Ingots::rows();
  } elseif($table === 'Components') {
      $headers  = Components::headers();
      $rows     = Components::rows();
  } elseif($table === 'Servers') {
      $headers  = Servers::headers();
      $rows     = Servers::rows();
  } elseif($table === 'Stations') {
      $headers  = Stations::headers();
      $rows     = Stations::rows();
  } elseif($table === 'TradeZones') {
      $headers  = TradeZones::headers();
      $rows     = TradeZones::rows();
  } elseif($table === 'Clusters') {
      $headers  = Clusters::headers();
      $rows     = Clusters::rows();
  } elseif($table === 'MagicNumbers') {
      $headers  = MagicNumbers::headers();
      $rows     = MagicNumbers::rows();
  } elseif($table === 'SystemTypes') {
      $headers  = SystemTypes::headers();
      $rows     = SystemTypes::rows();
  }

  return ['headers' => $headers, 'rows' => $rows];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Raw Data</title>
  <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link href="public/css/default.css" type="text/css" rel="stylesheet">
  <script src="public/js/default.js"></script>

</head>
<body>
<?php require_once('menubar.php'); ?>
<article class="tabs">
    <?php foreach($tables as $table) :
        $tableData = read($table);
        ?>
      <section id="<?=$table;?>" class="simpleDisplay">
        <h2><a class="headerTitle" href="#<?=$table;?>"><?=$table;?></a></h2>
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
</body>
</html>