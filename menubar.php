<header class="header">
  <h1 class="logo"><a href="index.php">Commodity Market for the "<?=$thisCluster->title?>"</a></h1>
<div class="main-nav">
  <div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Offers
      <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li id="buildOfferLink"><a href="ores_offer.php">Ores</a></li>
      <li id="buildOfferLink"><a href="ingots_offer.php">Ingots</a></li>
      <li id="buildOfferLink"><a href="components_offer.php">Components</a></li>
    </ul>
  </div>
  <div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Orders
      <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li id="buildOrderLink"><a href="ores_order.php">Ores</a></li>
      <li id="buildOrderLink"><a href="ingots_order.php">Ingots</a></li>
      <li id="buildOrderLink"><a href="components_order.php">Components</a></li>
    </ul>
  </div>
  <div class="dropdown">
  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Test Data
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li id="spreadsheetLink"><a href="stock_levels.php">Stock Levels</a></li>
      <li id="tradetestLink"><a href="trade_station_data.php">Trade Station Data</a></li>
    </ul>
  </div>
  <div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">User
      <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li id="resetLink"><a href="reset-password.php">Reset Password</a></li>
      <li id="logoutLink"><a href="logout.php"><b>Logout</b></a></li>
    </ul>
  </div>
</div>
</header>