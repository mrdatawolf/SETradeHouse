<header class="header">
  <h1 class="logo"><a href="index.php">Commodity Market For</a></h1>
  &nbsp;<label for="pick_cluster"></label>
  <select id="pick_cluster" name="pick_cluster">
    <?php foreach(\Models\Clusters::all() as $cluster) : ?>
      <option value="<?=$cluster->id;?>"><?=$cluster->title;?></option>
    <?php endforeach ?>
  </select>
  <ul class="main-nav">
    <li id="loginLink"><a href="login.php">Login</a></li>
    <li id="logoutLink"><a href="logout.php">Logout</a></li>
    <li id="registerLink"><a href="register.php">Register</a></li>
    <li id="resetLink"><a href="reset-password.php">Reset Password</a></li>
    <li id="spreadsheetLink"><a href="spreadsheet.php">Spreadsheet</a></li>
    <li id="rawdataLink"><a href="rawdata.php">Raw Data</a></li>
    <li id="tradetestLink"><a href="trade_tests.php">Trade Tests</a></li>
  </ul>

</header>