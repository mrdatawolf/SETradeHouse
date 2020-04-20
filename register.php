<?php require "start.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Set parameters
        $param_username = trim($_POST["username"]);
        // Prepare a select statement
        $users = Users::select('id')->where('username', $param_username);
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

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        // Set parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        // Prepare an insert statement
        $users = new Users();
        $users->username = $param_username;
        $users->password = $param_password;
        $users->save();
    }

}
?>
<div class="wrapper">
    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?= (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $username; ?>">
            <span class="help-block"><?= $username_err; ?></span>
        </div>
        <div class="form-group <?= (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?= $password; ?>">
            <span class="help-block"><?= $password_err; ?></span>
        </div>
        <div class="form-group <?= (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="<= $confirm_password; ?>">
            <span class="help-block"><?= $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>

<?php require_once ('end.php'); ?>

