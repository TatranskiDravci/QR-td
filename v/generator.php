<?php
require_once "php/logged.php";/*
require_once "https://".$_SERVER['HTTP_HOST']."/include/conn.php";

$VTPMeno = $VTPHeslo = '';
$VTPMeno_err = $VTPHeslo_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {
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
          $VTPMeno_err = "Tento email už je zaregistrovaný. <a href='../login.php'>Prihlásiť sa</a>";
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
}*/
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDEM</title>
  <?php include "../include/head.php"; ?>
</head>
    <body>
        <?php include "../include/nav_min.php";?>
        <div class="container">
            <div class="row" id="firstStep">
                <div class="col-12">
                    <div class="wrapper col-12 offset-md-2 col-md-8 text-center">
                        <h2>Vytvoriť expedíciu</h2>
                        <form>
                            <div class="mb-3 text-start">
                                <label for="name" class="form-label">Názov expedície</label>
                                <input type="text" class="form-control" id="ename" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3 text-start">
                                <label for="name" class="form-label">Prihlasovacie meno tímu</label>
                                <input type="text" class="form-control" id="euname" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3 text-start">
                                <label for="hint" class="form-label">Prihlasovacie heslo tímu</label>
                                <input type="text" class="form-control" id="epass">
                            </div>
                        </form>
                        <div class="text-end">
                            <button class="btn btn-success" id="register">Vytvoriť expedíciu</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="secondStep" style="display: none;">
            <div class="row">
                <div class="col-12">
                    <div class="wrapper col-12 offset-md-2 col-md-8 text-center">
                        <h2>Vytvoriť trasu</h2>
                        <p>Pripravte si pre vaše tímy trasu s QR kódmi.</p>
                        <form>
                            <div class="mb-3 text-start">
                                <label for="name" class="form-label">Meno checkpointu</label>
                                <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3 text-start">
                                <label for="hint" class="form-label">Indícia</label>
                                <input type="text" class="form-control" id="hint">
                            </div>
                        </form>
                        <div class="text-end">
                            <button class="btn btn-success" id="create">Vytvoriť</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <div class="wrapper col-12 offset-md-2 col-md-8 text-center gx-5">
                        <div class="list-group col" id="table">
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary" id="download" style="display: none;">Stiahnúť</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
        <script src="js/uuid.js"></script>
        <script src="js/generator.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
                crossorigin="anonymous">
        </script>
    </body>
</html>
