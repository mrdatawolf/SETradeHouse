
<?php
require_once('ores.php');
require_once('ingots.php');
require_once('components.php');
require_once('servers.php');
require_once('stations.php');
require_once('tradeZones.php');
$ores = new ores();
$ores->read();

$ingots = new ingots();
$ingots->read();

$components = new components();
$components->read();

$servers = new components();
$servers->read();

$stations = new stations();
$stations->read();

$tradeZones = new tradeZones();
$tradeZones->read();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Landing Page</title>
  <style>
    /* general table styling */
    table {
      border: 2px solid #CCCCCC;
    }
    table td, table th {
      border: 1px solid #CCC;
      border-collapse: collapse;
      padding: 1em;
      font-family: Tahoma, sans-serif;
    }
    table tr:nth-of-type(2n + 2) {
      background-color: #ECF7FF;
    }
    table td:nth-of-type(1), table th:nth-of-type(1) {
      width: 5em;
      text-align: center;
    }
    table th {
      font-size: 10pt;
      background-color: #DDE9FF;
    }
    table td {
      font-size: 8pt;
    }

/* this gets the tabs setup */
    article.tabs {
      position: relative;
      display: block;
      width: 65em;
      height: 38em;
      margin: 2em auto;
    }

    article.tabs section {
      position: absolute;
      display: block;
      top: 1.8em;
      left: 0;
      right: 0;
      height: 32em;
      padding: 10px 20px;
      background-color: #ddd;
      border-radius: 5px;
      box-shadow: 0 3px 3px rgba(0,0,0,0.1);
      z-index: 0;
      color: black;
    }

    article.tabs section .tab-content { display: none; }

    article.tabs section:last-child {
      z-index: 1;
      color: #333;
      background-color: #fff;
    }

    article.tabs section:last-child .tab-content { display: block; }

    article.tabs section h2 {
      position: absolute;
      font-size: 1em;
      font-weight: normal;
      width: 120px;
      height: 1.8em;
      top: -1.8em;
      left: 10px;
      padding: 0;
      margin: 0;
      color: #999;
      background-color: #ECF7FF;
      border-radius: 5px 5px 0 0;
    }

    article.tabs section:nth-child(1) h2 { left: 132px; }
    article.tabs section:nth-child(2) h2 { left: 254px; }
    article.tabs section:nth-child(3) h2 { left: 376px; }
    article.tabs section:nth-child(4) h2 { left: 498px; }
    article.tabs section:nth-child(5) h2 { left: 620px; }
    article.tabs section:nth-child(6) h2 { left: 742px; }

    article.tabs section h2 a {
      display: block;
      width: 100%;
      line-height: 1.8em;
      text-align: center;
      text-decoration: none;
      color: inherit;
      outline: 0 none;
    }

    article.tabs section:target, article.tabs section:target h2 {
      color: #333;
      background-color: #fff;
      z-index: 2;
    }

    article.tabs section:target h2{
      background-color: #DDE9FF;
    }

    article.tabs section:target .tab-content { display: block; }

    article.tabs section:target ~ section:last-child h2 {
      color: #999;
    }

    article.tabs section:target ~ section:last-child .tab-content { display: none; }
  </style>
</head>
<body>


<article class="tabs">

  <section id="ores">
    <h2><a href="#ores">Ores</a></h2>
    <div class="tab-content">
      <table>
        <thead>
        <tr>
            <?php foreach($ores->headers as $header) : ?>
              <th><?=$header; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($ores->rows as $data) : ?>
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
  <section id="ingots">
    <h2><a href="#ingots">Ingots</a></h2>
    <div class="tab-content">
      <table>
        <thead>
        <tr>
            <?php foreach($ingots->headers as $header) : ?>
              <th><?=$header; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($ingots->rows as $data) : ?>
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
  <section id="components">
    <h2><a href="#components">Components</a></h2>
    <div class="tab-content">Components Panel</div>
  </section>
  <section id="servers">
    <h2><a href="#servers">Servers</a></h2>
    <div class="tab-content">Server Panel</div>
  </section>
  <section id="stations">
    <h2><a href="#stations">Stations</a></h2>
    <div class="tab-content">Stations Panel</div>
  </section>
  <section id="tradezones">
    <h2><a href="#tradezones">TradeZones</a></h2>
    <div class="tab-content">TradeZones Panel</div>
  </section>
</article>
</body>
</html>