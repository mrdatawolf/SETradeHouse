<header class="header">
  <h1 class="logo"><a href="index.php"><label for="pick_cluster">Commodity Market For</label></a></h1>
  &nbsp;
  <select id="pick_cluster" name="pick_cluster">
    <?php foreach(\Models\Clusters::all() as $cluster) : ?>
      <option value="<?=$cluster->id;?>"><?=$cluster->title;?></option>
    <?php endforeach ?>
  </select>
  <ul class="main-nav">
    <li id="spreadsheetLink"><a href="spreadsheet.php">Spreadsheet</a></li>
    <li id="rawdataLink"><a href="rawdata.php">Raw Data</a></li>
    <li id="tradetestLink"><a href="trade_tests.php">Trade Tests</a></li>
  </ul>

</header>