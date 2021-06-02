<?php
//logged in???
session_start();
if(isset($_SESSION["vLoggedIn"]) && $_SESSION["vLoggedIn"] === true){
  header("location: index.php");
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

$vMeno = $vPriezvisko = $vEmail = $vPass = $vTel = $vMesto = '';
$vEmail_err = $vPass_err = $err = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  //ukladanie udajov ak by bola chyba aby sa to nemuselo vypisovat znaova
  if(!empty(trim($_POST["vMeno"]))){
    $vMeno = trim($_POST["vMeno"]);
  }
  if(!empty(trim($_POST["vPriezvisko"]))){
    $vPriezvisko = trim($_POST["vPriezvisko"]);
  }
  if(!empty(trim($_POST["vTel"]))){
    $param_vTel = trim($_POST["vTel"]);
  }
  if(!empty(trim($_POST["vMesto"]))){
    $param_vMesto = trim($_POST["vMesto"]);
  }
  //check if email already exists
  if(empty(trim($_POST["vEmail"]))){
    $vEmail_err = "Prosím napíšte email.";
  } else{
    $sql = "SELECT `vId` FROM `TD-Veduci` WHERE `vEmail` = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
      mysqli_stmt_bind_param($stmt, "s", $param_vEmail);
      $param_vEmail = trim($_POST["vEmail"]);

      if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
          $vEmail_err = "Tento email už je zaregistrovaný. <a href='login.php'>Prihlásiť sa</a>";
        } else{
          $vEmail = trim($_POST["vEmail"]);
        }
      } else{
        echo "Niekde nastala chyba.";
      }
      mysqli_stmt_close($stmt);
    }
  }

  //check if pass meets conditions
  if(empty(trim($_POST["vPass"]))){
    $vPass_err = "Prosím napíšte heslo";
  } elseif(strlen(trim($_POST["vPass"])) < 6){
    $vPass_err = "Heslo musí mať aspoň 6 znakov.";
  } else{
    $vPass = trim($_POST["vPass"]);
  }

  //check if any errors occurred than send to DB
  if(empty($vEmail_err) && empty($vPass_err) && !empty(trim($_POST["vTel"])) && !empty(trim($_POST["vMesto"]))){
    $sql = "INSERT INTO `TD-Veduci` (`vId`, `vMeno`, `vPriezvisko`, `vEmail`, `vPass`, `vTel`, `vMesto`) VALUES (?, ?, ?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($conn, $sql)){
      mysqli_stmt_bind_param($stmt, "sssssss", $param_vId, $param_vMeno, $param_vPriezvisko, $param_vEmail, $param_vPass, $param_vTel, $param_vMesto);
      // TODO Prepared statements (Mesto, tel.c) iba ka su vypisane - momentalne su required
      // Set parameters
      $param_vId = bin2hex(random_bytes(32));
      $param_vMeno = $vMeno;
      $param_vPriezvisko = $vPriezvisko;
      $param_vEmail = $vEmail;
      $param_vPass = password_hash($vPass, PASSWORD_DEFAULT);

      if(mysqli_stmt_execute($stmt)){
        header("location: login.php");
      } else{
        echo "Niekde nastala chyba.";
      }
      mysqli_stmt_close($stmt);
    }
  } else {
      $err = "Niekde nastala chyba.";
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
        <h2>Registrácia - Vedúci</h2>
        <p>Vytvorte si účet ako vedúci a sledujte aktivitu vašich tímov.</p>
        <?php if(!empty(trim($err))) {echo "<div class='alert alert-danger' role='alert'>" . $err . "</div>";}?>
      </div>
        <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="col-md-6">
            <label class="form-label" for="vMeno">Meno:</label>
            <input type="text" class="form-control" id="vMeno" name="vMeno" value="<?php echo $vMeno; ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label" for="vPriezvisko">Priezvisko:</label>
            <input type="text" class="form-control" id="vPriezvisko" name="vPriezvisko" value="<?php echo $vPriezvisko; ?>">
          </div>
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
          <div class="col-6">
            <label class="form-label" for="vTel">Telefónne číslo:</label>
            <input type="text" class="form-control" id="vTel" name="vTel" value="<?php echo $vTel; ?>" aria-describedby="vTelHelp" placeholder="+421 9XX XXX XXX">
            <div id="vTelHelp" class="form-text">Vase cislo nebudeme potrebovat ale vase timy ano. placeholder.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="vMesto">Mesto:</label>
            <input type="text" class="form-control" id="vMesto" name="vMesto" value="<?php echo $vMesto; ?>">
          </div><!--
          <div class="col-md-6">
            <label for="vPouzitie" class="form-label">Použitie:</label>
            <select id="vPouzitie" name="vPouzitie" class="form-select" aria-label="Vyberte použitie aplikácie">
              <option value="vDofe">DofE</option>
              <option value="vSutaz">Športová súťaž</option>
              <option value="vBranne">Branné cvičenie</option>
              <option value="vUloha">Interaktívna úloha v triede</option>
            </select>
          </div>-->
          <div class="col-md-8">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Súhlasím s používanim a ukladaním osobných údajov. <a href="#gdpr">Viac info...</a>
              </label>
            </div>
          </div>
          <div class="col-md-4 form-check text-end">
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
