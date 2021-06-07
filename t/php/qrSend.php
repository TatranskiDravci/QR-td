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

session_start();
$tId = $_SESSION("tId");
$trId = $_GET["trId"];
if (!empty(trim($trId))) {
  $sql = "
    UPDATE `TD-TimyTrasy`
    INNER JOIN `TD-Trasy` ON `TD-TimyTrasy`.`trId` = `TD-Trasy`.`trId`
    SET `TD-Trasy`.`trTuSme` = 0
    WHERE `TD-TimyTrasy`.`tId` = '" . $tId . "'";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $param_tId);
    $param_tId = 0;

    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
      $sql = "
      UPDATE `TD-Trasy` 
      SET `TD-Trasy`.`trTuSme` = ?, `TD-Trasy`.`trTimeSubmited` = ?, `TD-Trasy`.`trTimeUploaded` = ? 
      WHERE `TD-Trasy`.`trId` = '" . $trId . "'";

      if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iss", $param_trTuSme, $param_trTimeSubmited, $param_trTimeUploaded);

        $param_trTuSme = 1;
        $param_trTimeSubmited = date(d-m-Y H:i:s);
        $param_trTimeUploaded = date(d-m-Y H:i:s);

        // Add IDs to connections table
        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_close($stmt);
        }
      }
    }
  }
}
mysqli_close($conn);