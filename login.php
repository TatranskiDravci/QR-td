<?php
//logged in???
session_start();
if(isset($_SESSION["vLoggedIn"]) && $_SESSION["vLoggedIn"] === true){
  header("location: v/index.php");
  exit;
}
if(isset($_SESSION["tLoggedIn"]) && $_SESSION["tLoggedIn"] === true){
  header("location: t/index.php");
  exit;
}

define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'f147316');
define('DB_PASSWORD', 'S86FnMnR');
define('DB_NAME', 'f147316');
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($conn === false) {
  die('Connect Error: ' . mysqli_connect_error());
}

$vEmail = $vPass = "";
$vEmail_err = $vPass_err = $err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["vEmail"]))) {
    $vEmail_err = "Please enter username.";
  } else {
    $vEmail = trim($_POST["vEmail"]);
  }
  if (empty(trim($_POST["vPass"]))) {
    $vPass_err = "Please enter your password.";
  } else {
    $vPass = trim($_POST["vPass"]);
  }

  if (filter_var($vEmail, FILTER_VALIDATE_EMAIL)) {
    if (empty($vEmail_err) && empty($vPass_err)) {
      $sql = "SELECT `vId`, `vEmail`, `vPass`, `vMeno` FROM `TD-Veduci` WHERE `vEmail` = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_vEmail);
        $param_vEmail = $vEmail;

        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $vId, $DBvEmail, $DBvPassHashed, $DBvMeno);
            if (mysqli_stmt_fetch($stmt)) {
              if (password_verify($vPass, $DBvPassHashed)) {
                $_SESSION["vLoggedIn"] = true;
                $_SESSION["vId"] = $vId;
                $_SESSION["vEmail"] = $DBvEmail;
                $_SESSION["vMeno"] = $DBvMeno;
                header("location: v/index.php");
              } else {
                $err = "Nesprávne meno alebo heslo.";
              }
            }
          } else {
            $err = "Nesprávne meno alebo heslo.";
          }
        } else {
          echo "Nastala chyba. Skúste znova neskôr.";
        }
        mysqli_stmt_close($stmt);
      }
    }
  } else {
      if (empty($vEmail_err) && empty($vPass_err)) {
        $sql = "SELECT `tId`, `tMeno`, `tHeslo` FROM `TD-Timy` WHERE `tPrihlasovacieMeno` = ? ";

        if($stmt = mysqli_prepare($conn, $sql)) {
          mysqli_stmt_bind_param($stmt, "s", $param_vEmail);
          $param_vEmail = $vEmail;

          if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){
              mysqli_stmt_bind_result($stmt, $tId, $tMeno, $tHesloHashed);
              if(mysqli_stmt_fetch($stmt)){
                if(password_verify($vPass, $tHesloHashed)){
                  $_SESSION["tLoggedIn"] = true;
                  $_SESSION["tId"] = $tId;
                  $_SESSION["tMeno"] = $tMeno;
                  header("location: t/index.php");
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
          <input type="text" class="form-control <?php echo (!empty($vEmail_err)) ? 'is-invalid' : ''; ?>" id="vEmail" name="vEmail" value="<?php echo $vEmail; ?>">
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
</html>