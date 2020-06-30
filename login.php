<?php
require 'vendor/autoload.php';
require 'config.php';
require 'functions.php';

new Models\Database();
use Models\Users;
// Initialize the session
session_start();
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validate credentials
    if(empty($username_err) && empty($password_err)){

        $users = Users::where('username', $username);
        // Check if username exists, if yes then verify password
        if($users->count() === 1){
            $user = $users->first();
            if(password_verify($password, $user->password)){
                // Password is correct, so start a new session
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user->id;
                $_SESSION["cluster_id"] = $user->cluster_id;
                $_SESSION["username"] = $user->username;

                // Redirect user to welcome page
                header("location: rawdata.php");
            } else{
                // Display an error message if password is not valid
                $password_err = "The password you entered was not valid.";
            }
        } else{
            // Display an error message if username doesn't exist
            $username_err = "No account found with that username.";
        }
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
  <div class="panel panel-default">
    <div class="panel-heading">
      <H3>Welcome to the Space Engineers Trading House Test</H3>
    </div>
      <div class="panel-body wrapper">
          <h2>Login</h2>
          <p>Please fill in your credentials to login.</p>
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                  <label for="username">Username</label>
                  <input id="username" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                  <span class="help-block"><?php echo $username_err; ?></span>
              </div>
              <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <label for="password">Password</label>
                  <input id="password" type="password" name="password" class="form-control">
                  <span class="help-block"><?php echo $password_err; ?></span>
              </div>
              <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Login">
              </div>
              <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
          </form>
      </div>
  </div>
  </body>
</html>