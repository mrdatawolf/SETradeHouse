<?php
require __DIR__ .'/vendor/autoload.php';

use Colonization\CorePHP;
use DB\dbClass;
$tablesRequired = ['ores','ingots','components','servers', 'stations', 'tradeZones', 'clusters', 'clusters_servers', 'magicNumbers', 'systemTypes', 'ingotsOres', 'oresServers', 'oresStations', 'serversLinks', 'serversSystemTypes'];
$corePHP = new CorePHP();
$dbClass = new dbClass();

function read($table) {
    $dbClass = new dbClass();
    $stmt = $dbClass->dbase->prepare("SELECT * FROM ".$table);
    $stmt->execute();

    $rowNumber = 0;
    $lastRow = [];
    $headers = [];
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $data) {
        $rowNumber++;
        foreach ($data as $key => $value) {
            if($key === 'base_cost_to_gather') {
                $value = sprintf('%f', $value);
                $key = $key . ' (rounded)';
            }
            if ($rowNumber === 1) {
                $headers[] = $key;

                $lastRow[$key] = $value;
            }
            $rows[$rowNumber][] = $value;
        }
    }
    $finalRowId = $rowNumber+1;
    $rows[$finalRowId] = addFinalRow($lastRow, $finalRowId, $table);

    return ['headers' => $headers, 'rows' => $rows];
}

function addFinalRow($lastRow, $finalRowId, $table) {
    $row = [];
    foreach($lastRow as $key => $value) {
        switch ($key) {
            case 'id' :
                $row[$key] = '<button id="addRow" class="addId" data-row_id="' . $finalRowId  . '" data-table="' . $table  . '" disabled><span class="fa fa-plus"></span></button>';
                break;
            case 'title' :
                $row[$key] = '<input type=text value="" data-type="title" class="addTitle">';
                break;
            default:
                $row[$key] = '<input type=text value="" data-type="general" class="addGeneral">';
        }
    }

    return $row;
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
    <?php foreach($tablesRequired as $table) :
        $tableName = $corePHP->getTableName($table);
        $tableData = read($tableName);
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