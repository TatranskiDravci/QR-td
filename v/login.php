<?php
//logged in???
session_start();
if(isset($_SESSION["vLoggedIn"]) && $_SESSION["vLoggedIn"] === true){
  header("location: index.php");
  exit;
}

require_once "../include/conn.php";

$vEmail = $vPass = "";
$vEmail_err = $vPass_err = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty(trim($_POST["vEmail"]))){
    $vEmail_err = "Please enter username.";
  } else{
    $vEmail = trim($_POST["vEmail"]);
  }
  if(empty(trim($_POST["vPass"]))){
    $vPass_err = "Please enter your password.";
  } else{
    $vPass = trim($_POST["vPass"]);
  }

  if(empty($vEmail_err) && empty($vPass_err)){
    $sql = "SELECT DBvId, DBvEmail, DBvPass, DBvMeno FROM veduciDB WHERE DBvEmail = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
      mysqli_stmt_bind_param($stmt, "s", $param_vEmail);
      $param_vEmail = $vEmail;

      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
          mysqli_stmt_bind_result($stmt, $vId, $DBvEmail, $DBvPassHashed, $DBvMeno);
          if(mysqli_stmt_fetch($stmt)){
            if(password_verify($vPass, $DBvPassHashed)){
              session_start();
              $_SESSION["vLoggedIn"] = true;
              $_SESSION["vId"] = $vId;
              $_SESSION["vEmail"] = $DBvEmail;
              $_SESSION["vMeno"] = $DBvMeno;
              header("location: index.php");
            } else{
              $err = "Nesprávne meno alebo heslo.";
            }
          }
        } else{
          $err = "Nesprávne meno alebo heslo.";
        }
      } else{
        echo "Nastala chyba. Skúste znova neskôr.";
      }
      mysqli_stmt_close($stmt);
    }
  }
  mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IDEM</title>
  <?php include '../include/head.php'; ?>
</head>
<body>
<?php include '../include/nav_min.php';?>
<div class="container">
  <div class="row">
    <div class="col-12 offset-md-2 col-md-8">
      <div class="col-12 text-center">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <?php if(!empty(trim($err))) {echo "<div class='alert alert-danger' role='alert'>" . $err . "</div>";}?>
      </div>
      <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="col-12">
          <label class="form-label" for="vEmail">Email:</label>
          <input type="email" class="form-control <?php echo (!empty($vEmail_err)) ? 'is-invalid' : ''; ?>" id="vEmail" name="vEmail" value="<?php echo $vEmail; ?>">
          <span class="invalid-feedback"><?php echo $vEmail_err; ?></span>
        </div>
        <div class="col-12">
          <label class="form-label" for="vPass">Password</label>
          <input type="password" class="form-control <?php echo (!empty($vPass_err)) ? 'is-invalid' : ''; ?>" id="vPass" name="vPass" value="<?php echo $vPass; ?>">
          <span class="invalid-feedback"><?php echo $vPass_err; ?></span>
        </div>
        <div class="col-12 form-check text-end">
          <button type="submit" class="btn btn-primary">Potvrdiť</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous">
</script>
</body>
</html><!--
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
        </form>-->