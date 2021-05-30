<?php
require 'php/logged.php';
require_once '../include/conn.php';

$VTPMeno = $VTPHeslo = '';
$VTPMeno_err = $VTPHeslo_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  /*if(!empty(trim($_POST["vMeno"]))){
    $vMeno = trim($_POST["vMeno"]);
  }*/
  //check if email already exists
  if (empty(trim($_POST["vEmail"]))) {
    $vEmail_err = "Prosím napíšte email.";
  } else {
    $sql = "SELECT DBtPMeno FROM timyDB WHERE DBtPMeno = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $param_tPMeno);
      $param_tPMeno = trim($_POST["VTPMeno"]);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          $VTPMeno_err = "Tento email už je zaregistrovaný. <a href='login.php'>Prihlásiť sa</a>";
        } else {
          $VTPMeno = trim($_POST["VTPMeno"]);
        }
      } else {
        echo "Niekde nastala chyba.";
      }
      mysqli_stmt_close($stmt);
    }
  }
  //check if pass meets conditions
  if (empty(trim($_POST["VTPHeslo"]))) {
    $VTPHeslo_err = "Prosím napíšte heslo";
  } else {
    $VTPHeslo = trim($_POST["VTPHeslo"]);
  }
  //check if any errors occurred than send to DB
  if (empty($VTPMeno_err) && empty($VTPHeslo_err)) {
    $sql = "INSERT INTO timyDB (DBtId, DBtMeno, DBtPMeno, DBtPHeslo) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "ssss", $param_tId, $param_tMeno, $param_tPMeno, $param_tHeslo);

      // Set parameters
      $param_tId = bin2hex(random_bytes(32));
      $param_tMeno = "Placeholder";
      $param_tPMeno = trim($_POST["VTPMeno"]);
      $param_tHeslo = password_hash($VTPHeslo, PASSWORD_DEFAULT);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $sql = "INSERT INTO VeduciTimyDB (DBvId, DBtId) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
          mysqli_stmt_bind_param($stmt, "ss", $param_vId, $param_tId);
          $param_vId = $_SESSION["vId"];
          if (mysqli_stmt_execute($stmt)) {
              header("location: index.php");
            } else {
              $err = "Niekde nastala chyba.";
            }
          mysqli_stmt_close($stmt);
        } else {
          $err = "Niekde nastala chyba.";
        }
      }
    } else {
      $err = "Niekde nastala chyba.";
    }

    mysqli_close($conn);
  }
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
                <div class="col-12">
                    <label class="form-label" for="VTPMeno">Pouzivatelske meno Placeholder:</label>
                    <input type="text" class="form-control <?php echo (!empty($VTPMeno_err)) ? 'is-invalid' : ''; ?>" id="VTPMeno" name="VTPMeno" value="<?php echo $VTPMeno; ?>">
                    <span class="invalid-feedback"><?php echo $VTPMeno_err; ?></span>
                </div>
                <div class="col-12">
                    <label class="form-label" for="VTPHeslo">Heslo:</label>
                    <input type="password" class="form-control <?php echo (!empty($VTPHeslo_err)) ? 'is-invalid' : ''; ?>" id="VTPHeslo" name="VTPHeslo" value="<?php echo $VTPHeslo; ?>">
                    <span class="invalid-feedback"><?php echo $VTPHeslo_err; ?></span>
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
