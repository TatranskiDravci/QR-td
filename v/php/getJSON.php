<?php
//require 'logged.php';
define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'f147316');
define('DB_PASSWORD', 'S86FnMnR');
define('DB_NAME', 'f147316');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false) {
  die('Connect Error: ' . mysqli_connect_error());
}

$err = "";

$getFromFile = file_get_contents('array.json');
$arr = json_decode($getFromFile, true);

$value = $arr["expedition"];
if (empty($err)) {
  $sql = "INSERT INTO timyDB (DBtId, DBtMeno, DBtPMeno, DBtPHeslo) VALUES (?, ?, ?, ?)";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssss", $param_tId, $param_tMeno, $param_tPMeno, $param_tHeslo);

    $param_tId = bin2hex(random_bytes(32));
    $param_tMeno = $value["name"];
    $param_tPMeno = $value["PName"];
    $param_tHeslo = password_hash($value["pass"], PASSWORD_DEFAULT);

    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
      $sql = "INSERT INTO VeduciTimyDB (DBvId, DBtId) VALUES (?, ?)";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_vId, $param_tId);
        session_start();
        $param_vId = $_SESSION["vId"];
        if (mysqli_stmt_execute($stmt)) {
          echo 'good';
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
}
echo $err;
$err = "";

foreach ($arr["QR"] as $value) {
  $sql = "INSERT INTO QRdynamicDB (QRid, QRMeno, QRsprava) VALUES (?, ?, ?)";
  if($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "iss", $param_QRid, $param_QRMeno, $param_QRsprava);

    $param_QRid = $value["QRid"];
    $param_QRMeno = $value["QRMeno"];
    $param_QRsprava = $value["QRsprava"];

    if (mysqli_stmt_execute($stmt)) {
      echo 'good';
    }
    else {
      $err = "Vyskytol sa problem.";
    }
    mysqli_stmt_close($stmt);
  }
  else {
    $err = "Vyskytol sa problem.";
  }
}
echo $err;
$err = "";

foreach ($arr["History"] as $value) {
  $sql = "INSERT INTO historyDB (hID, hQRid, hPoradie) VALUES (?, ?, ?)";
  if($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sii", $param_hId, $param_QRid, $param_hPoradie);

    $param_hId = $value["hId"]; //Kodovanie v PHP namiesto JS??
    $param_QRid = $value["QRid"];
    $param_hPoradie = $value["hPoradie"];

    if (mysqli_stmt_execute($stmt)) {
      echo 'good';
      mysqli_stmt_close($stmt);
      $sql = "INSERT INTO TimyHistoryDB (tId, hId) VALUES (?, ?)";
      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_tId, $param_hId);
        if (mysqli_stmt_execute($stmt)) {
          echo 'good';
        } else {
          $err = "Niekde nastala chyba.";
        }
        mysqli_stmt_close($stmt);
      } else {
        $err = "Niekde nastala chyba.";
      }
    }
    else {
      $err = "Vyskytol sa problem..";
    }
  }
  else {
    $err = "Vyskytol sa problem.";
  }
}
echo $err;
mysqli_close($conn);