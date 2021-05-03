<?php
session_start();

if(isset($_SESSION["loggedinM"]) && $_SESSION["loggedinM"] === true){
  header("location: welcome.php");
  exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        if ($username == "Mentor" && $password == "Mentorove*Heslo") {
            session_start();
            $_SESSION["loggedinM"] = true;
            header("location: welcome.php");
        } else {
          $login_err = "Meno alebo heslo nie je správne.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RobotikaQR - Login</title>
    <style>
      .wrapper{padding: 20px;}
    </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="wrapper col-12 offset-md-2 col-md-8">
          <h2>Login</h2>
          <p>Please fill in your credentials to login.</p>
          <?php
          if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
          }
          ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="usernameL" class="form-label">Username</label>
              <input id="usernameL" type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
              <label for="passwordL" class="form-label">Password</label>
              <input id="passwordL" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group row g-0">
              <div class="col-9 p-2"><p>Don't have an account? <a href="register.php">Sign up now</a>.</p></div>
              <div class="col-3 text-right"><input type="submit" class="btn btn-primary" value="Login"></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>