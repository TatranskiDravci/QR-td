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

session_start();
$tId = $_SESSION['tId'];
$sql = "SELECT `TD-Trasy`.`trId`, `TD-Trasy`.`trQrId`, `TD-Trasy`.`trPoradie`, `TD-Qr`.`dMeno`, `TD-Qr`.`dSprava`
FROM `TD-TimyTrasy`
INNER JOIN `TD-Trasy` ON `TD-TimyTrasy`.`trId` = `TD-Trasy`.`trId`
INNER JOIN `TD-Qr` ON `TD-Trasy`.`trQrId` = `TD-Qr`.`dId`
WHERE `TD-TimyTrasy`.`tId` = '" . $tId . "' 
ORDER BY `TD-Trasy`.`trPoradie`";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $jsonobj2 = array();
  while($row = mysqli_fetch_assoc($result)) {
    $jsonobj2i = array("trId" => $row["trId"], "trQrId" => $row["trQrId"], "trPoradie" => $row["trPoradie"], "dMeno" => $row["dMeno"], "dSprava" => $row["dSprava"]);
    array_push($jsonobj2, $jsonobj2i);
  }
  $arr = json_encode($jsonobj2);
  echo $arr;
} else {
  echo "Nepodarilo sa získať záznamy.";
}
mysqli_free_result($result);
mysqli_close($conn);