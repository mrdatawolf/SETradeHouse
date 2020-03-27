<?php
require 'start.php';

use Controllers\Ores;

//$tablesRequired = ['ores','ingots','components','servers', 'stations', 'trade_zones', 'clusters', 'clusters_servers', 'magic_numbers', 'system_types', 'servers_links'];
$tables = ['Ores'];

function read($table) {
  return ['headers' => Ores::headers(), 'rows' => Ores::rows()];
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