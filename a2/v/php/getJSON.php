<?php
define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'f147316');
define('DB_PASSWORD', 'S86FnMnR');
define('DB_NAME', 'f147316');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false) {
  die('Connect Error: ' . mysqli_connect_error());
}

$err = "";

$getFromFile = file_get_contents('php://input');
$arr = json_decode($getFromFile, true);

$value = $arr["expedition"];
if (empty($err)) {
  $sql = "INSERT INTO `TD-Timy` (`tId`, `tMeno`, `tPrihlasovacieMeno`, `tHeslo`) VALUES (?, ?, ?, ?)";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssss", $param_tId, $param_tMeno, $param_tPMeno, $param_tHeslo);

    $param_tId = bin2hex(random_bytes(32));
    $param_tMeno = $value["tMeno"];
    $param_tPMeno = $value["tPrihlasovacieMeno"];
    $param_tHeslo = password_hash($value["tHeslo"], PASSWORD_DEFAULT);

    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
      $sql = "INSERT INTO `TD-VeduciTimy` (`vId`, `tId`) VALUES (?, ?)";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_vId, $param_tId);
        session_start();
        $param_vId = $_SESSION["vId"];
        if (mysqli_stmt_execute($stmt)) {
          echo 'good';
        } else {
          echo "Niekde nastala chyba...";
        }
        mysqli_stmt_close($stmt);
      } else {
        echo "Niekde nastala chyba..";
      }
    }
  } else {
    echo "Niekde nastala chyba.";
  }
}
echo "<br>";
$err = "";

foreach ($arr["QR"] as $value) {
  $sql = "INSERT INTO `TD-Qr` (`dId`, `dMeno`, `dSprava`) VALUES (?, ?, ?)";
  if($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sss", $param_QRid, $param_QRMeno, $param_QRsprava);

    $param_QRid = $value["dId"];
    $param_QRMeno = $value["dMeno"];
    $param_QRsprava = $value["dSprava"];

    if (mysqli_stmt_execute($stmt)) {
      echo 'good';
    }
    else {
      echo "Vyskytol sa problem..";
    }
    mysqli_stmt_close($stmt);
  }
  else {
    echo "Vyskytol sa problem.";
  }
}
echo "<br>";
$err = "";

foreach ($arr["History"] as $value) {
  $sql = "INSERT INTO `TD-Trasy` (`trId`, `trQrId`, `trPoradie`, `trTuSme`) VALUES (?, ?, ?, ?)";
  if($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssii", $param_hId, $param_QRid, $param_hPoradie, $param_trTuSme);

    $param_hId = bin2hex(random_bytes(32)); //Kodovanie v PHP namiesto JS??
    $param_QRid = $value["trQrId"];
    $param_hPoradie = $value["trPoradie"];
    $param_trTuSme = 0;

    if (mysqli_stmt_execute($stmt)) {
      $err = 'good';
      mysqli_stmt_close($stmt);
      $sql = "INSERT INTO `TD-TimyTrasy` (`tId`, `trId`) VALUES (?, ?)";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_tId, $param_hId);
        if (mysqli_stmt_execute($stmt)) {
          echo 'good';
        } else {
          echo "Niekde nastala chyba....";
        }
        mysqli_stmt_close($stmt);
      } else {
        echo "Niekde nastala chyba...";
      }
    }
    else {
      echo "Vyskytol sa problem..";
    }
  }
  else {
    echo "Vyskytol sa problem.";
  }
}
echo "<br>";
$err = "";
mysqli_close($conn);