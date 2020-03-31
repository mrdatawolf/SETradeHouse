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

$tables = ['Ores', 'Ingots', 'Components', 'Servers', 'Stations', 'TradeZones', 'Clusters', 'MagicNumbers', 'SystemTypes'];

function read($table) {
    $headers = null;
    $rows = null;
  if($table === 'Ores') {
      $ores     = new Ores(2);
      $headers  = $ores->headers();
      $rows     = $ores->rows();
  } elseif($table === 'Ingots') {
      $ingots   = new Ingots(2);
      $headers  = $ingots->headers();
      $rows     = $ingots->rows();
  } elseif($table === 'Components') {
      $components   = new Components(2);
      $headers      = $components->headers();
      $rows         = $components->rows();
  } elseif($table === 'Servers') {
      $servers  = new Servers(2);
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
      $clusters = new Clusters(2);
      $headers  = $clusters->headers();
      $rows     = $clusters->rows();
  } elseif($table === 'MagicNumbers') {
      $magicNumbers = new MagicNumbers();
      $headers      = $magicNumbers->headers();
      $rows         = $magicNumbers->rows();
  } elseif($table === 'SystemTypes') {
      $systemTypes  = new SystemTypes();
      $headers      = $systemTypes->headers();
      $rows         = $systemTypes->rows();
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