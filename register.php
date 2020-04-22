<?php
require 'vendor/autoload.php';
require 'config.php';
require 'functions.php';

new Models\Database();
use Models\Users;
use Models\Clusters;
$clusters = new Clusters();
// Initialize the session
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: rawdata.php");
}
// Define variables and initialize with empty values
$username = $password = $confirm_password = $confirm_cluster = "";
$username_err = $password_err = $confirm_password_err = $confirm_cluster_err ="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Set parameters
        $username = trim($_POST["username"]);
        // Prepare a select statement
        $users = Users::select('id')->where('username', $username);
        $sql = "SELECT id FROM users WHERE username = ?";


        // Attempt to execute the prepared statement

        if($users->count() >= 1){
            $username_err = "This username is already taken.";
        } else{
            $username = trim($_POST["username"]);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate cluster
    if(empty(trim($_POST["cluster"]))){
        $cluster_err = "Please enter a cluster.";
    } else{
        $cluster = trim($_POST["cluster"]);
    }

    // Validate confirm cluster
    if(empty(trim($_POST["confirm_cluster"]))){
        $confirm_cluster_err = "Please confirm cluster.";
    } else{
        $confirm_password = trim($_POST["confirm_cluster"]);
        if(empty($cluster_err) && ($cluster != $confirm_cluster)){
            $confirm_cluster_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        // Set parameters
        // Prepare an insert statement
        $users = new Users();
        $users->username = $username;
        $users->password = password_hash($password, PASSWORD_DEFAULT);
        $users->cluster_id = $cluster;
        $users->save();

        session_start();

        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $users->id;
        $_SESSION["cluster_id"] = $users->cluster_id;
        $_SESSION["username"] = $users->username;

        // Redirect user to welcome page
        header("location: rawdata.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link href="public/css/default.css" type="text/css" rel="stylesheet">
  <script src="public/js/default.js"></script>
  <script>
      if(localStorage.getItem("clusterId") === undefined) {
          localStorage.setItem("clusterId", 1);
      }
  </script>
</head>
<body>
<div class="wrapper">
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?= (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= $username; ?>">
            <span class="help-block"><?= $username_err; ?></span>
        </div>
        <div class="form-group <?= (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" value="<?= $password; ?>">
            <span class="help-block"><?= $password_err; ?></span>
        </div>
        <div class="form-group <?= (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<= $confirm_password; ?>">
            <span class="help-block"><?= $confirm_password_err; ?></span>
        </div>
        <div class="form-group <?= (!empty($confirm_cluster_err)) ? 'has-error' : ''; ?>">
            <label for="cluster" >Confirm Cluster</label>
            <select id="cluster" name="cluster">
              <?php foreach($clusters->all() as $clusterClass) {
                ?>
                <option value="<?=$clusterClass->id;?>"><?=$clusterClass->title;?></option>
              <?php
              } ?>

            </select>
            <span class="help-block"><?= $confirm_cluster_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</body>
</html>

