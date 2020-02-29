<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Landing Page</title>
  <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link href="public/css/default.css" type="text/css" rel="stylesheet">
  <script src="public/js/default.js"></script>

</head>
<?php
use Colonization\corePHP;
require __DIR__ .'/vendor/autoload.php';
$tablesRequired = ['ores','ingots','components','servers', 'stations', 'tradeZones'];
$corePHP = new corePHP();
?>
<body>
  <article class="tabs">
    <?php foreach($tablesRequired as $table) :
        $$table = $corePHP->readTable($table);
    ?>
      <section id="<?=$table;?>">
        <h2><a class="headerTitle" href="#<?=$table;?>"><?=$table;?></a></h2>
        <div class="tab-content">
          <table>
            <thead>
            <tr>
                <?php foreach($$table->headers as $header) : ?>
                  <th><?=$header; ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach($$table->rows as $data) : ?>
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
      <section id="test">
          <h2><a class="headerTitle" href="#test">test</a></h2>
          <div class="tab-content">
              <?php
              $data = $ores->getRefineryKiloWattHourForOre(1);
              
             
              ddng($data);
              ?>
          </div>
      </section>
  </article>
</body>
</html>