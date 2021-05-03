<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedinT"]) && $_SESSION["loggedinT"] === true){
  header("location: welcome.php");
  exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$tim = $password = "";
$tim_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Check if username is empty
  if(empty(trim($_POST["MenoT"]))){
    $tim_err = "Please enter username.";
  } else{
    $tim = trim($_POST["username"]);
  }

  // Check if password is empty
  if(empty(trim($_POST["Heslo"]))){
    $password_err = "Please enter your password.";
  } else{
    $password = trim($_POST["password"]);
  }

  // Validate credentials
  if(empty($tim_err) && empty($password_err)){
    // Prepare a select statement
    $sql = "SELECT userID, username, password FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($link, $sql)){
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = $tim;

      // Attempt to execute the prepared statement
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){
          // Bind result variables
          mysqli_stmt_bind_result($stmt, $id, $tim, $hashed_password);
          if(mysqli_stmt_fetch($stmt)){
            if(password_verify($password, $hashed_password)){
              // Password is correct, so start a new session
              session_start();

              // Store data in session variables
              $_SESSION["loggedinT"] = true;

              // Redirect user to welcome page
              header("location: welcome.php");
            } else{
              // Password is not valid, display a generic error message
              $login_err = "Invalid username or password.";
            }
          }
        } else{
          // Username doesn't exist, display a generic error message
          $login_err = "Invalid username or password.";
        }
      } else{
        echo "Oops! Something went wrong. Please try again later.";
      }

      // Close statement
      mysqli_stmt_close($stmt);
    }
  }

  // Close connection
  mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RobotikaQR - Login</title>
    <?php include('../include/head.php');?>
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
              <input id="usernameL" type="text" name="MenoT" class="form-control <?php echo (!empty($tim_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tim; ?>">
              <span class="invalid-feedback"><?php echo $tim_err; ?></span>
            </div>
            <div class="form-group">
              <label for="passwordL" class="form-label">Password</label>
              <input id="passwordL" type="password" name="Heslo" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
              <div class="col-3 text-right"><input type="submit" class="btn btn-primary" value="Login"></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>