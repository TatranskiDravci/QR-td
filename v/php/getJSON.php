<?php
// Connect to DB
define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'f147316');
define('DB_PASSWORD', 'S86FnMnR');
define('DB_NAME', 'f147316');
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($conn === false) {
  die('Connect Error: ' . mysqli_connect_error());
}

$err = "";

// Get stuff from JS input to array
$getFromFile = file_get_contents('php://input');
$arr = json_decode($getFromFile, true);

// Add expedition to DB
$value = $arr["expedition"];
if (empty($err)) {
  $sql = "INSERT INTO `TD-Timy` (`tId`, `tMeno`, `tPrihlasovacieMeno`, `tHeslo`) VALUES (?, ?, ?, ?)";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssss", $param_tId, $param_tMeno, $param_tPrihlasovacieMeno, $param_tHeslo);

    //TODO creating IDs with smaller chance of repeating
    $param_tId = bin2hex(random_bytes(32));
    $param_tMeno = $value["tMeno"];
    $param_tPrihlasovacieMeno = $value["tPrihlasovacieMeno"];
    $param_tHeslo = password_hash($value["tHeslo"], PASSWORD_DEFAULT);

    // Add IDs to connections table
    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
      $sql = "INSERT INTO `TD-VeduciTimy` (`vId`, `tId`) VALUES (?, ?)";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_vId, $param_tId);
        session_start();
        $param_vId = $_SESSION["vId"];

        if (mysqli_stmt_execute($stmt)) {
          // Add dynamic QR codes
          foreach ($arr["QR"] as $dValue) {
            $sql = "INSERT INTO `TD-Qr` (`dId`, `dMeno`, `dSprava`) VALUES (?, ?, ?)";
            if($stmt = mysqli_prepare($conn, $sql)) {
              mysqli_stmt_bind_param($stmt, "sss", $param_dId, $param_dMeno, $param_dSprava);
              $param_dId = $dValue["dId"];
              $param_dMeno = $dValue["dMeno"];
              $param_dSprava = $dValue["dSprava"];
              mysqli_stmt_execute($stmt);
            }
            else {
              $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní QR kódov. Skúste to znova.";
            }
          }
          if (empty($err)) {
            // Add checkpoints
            foreach ($arr["History"] as $trValue) {
              $sql = "INSERT INTO `TD-Trasy` (`trId`, `trQrId`, `trPoradie`, `trTuSme`) VALUES (?, ?, ?, ?)";
              if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssii", $param_trId, $param_trQrId, $param_trPoradie, $param_trTuSme);
                $param_trId = bin2hex(random_bytes(32)); //TODO do a new UUID system for checkpoints also
                $param_trQrId = $trValue["trQrId"];
                $param_trPoradie = $trValue["trPoradie"];
                $param_trTuSme = 0;
                if (mysqli_stmt_execute($stmt)) {

                  //Add IDs to connections table
                  mysqli_stmt_close($stmt);
                  $sql = "INSERT INTO `TD-TimyTrasy` (`tId`, `trId`) VALUES (?, ?)";
                  if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ss", $param_tId, $param_trId);
                    if (mysqli_stmt_execute($stmt)) {
                      $err = $param_tId;
                    } else {
                      $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní checkpointov. Skúste to znova.";
                    }
                    mysqli_stmt_close($stmt);
                  } else {
                    $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní checkpointov. Skúste to znova.";
                  }
                } else {
                  $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní checkpointov. Skúste to znova.";
                }
              } else {
                $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní checkpointov. Skúste to znova.";
              }
            }
          } else {
              $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní QR kódov. Skúste to znova.";
            }
            mysqli_stmt_close($stmt);

        } else {
          $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní expedície. Skúste to znova.";
        }
        mysqli_stmt_close($stmt);
      } else {
        $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní expedície. Skúste to znova.";
      }
    } else {
      $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní expedície. Skúste to znova.";
    }
  } else {
    $err = "Ospravedlňujeme sa, nastala chyba pri vytváraní expedície. Skúste to znova.";
  }
}
//TODO If error occurs delete what was added to DB before
mysqli_close($conn);
echo $err;