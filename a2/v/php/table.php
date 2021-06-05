<?php
define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'f147316');
define('DB_PASSWORD', 'S86FnMnR');
define('DB_NAME', 'f147316');
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($conn === false) {
  die('Connect Error: ' . mysqli_connect_error());
}

$tId = $_GET['tId'];
$sql = "SELECT *
FROM `TD-TimyTrasy`
INNER JOIN `TD-Trasy` ON `TD-TimyTrasy`.`trId` = `TD-Trasy`.`trId`
INNER JOIN `TD-Qr` ON `TD-Trasy`.`trQrId` = `TD-Qr`.`dId`
WHERE `TD-TimyTrasy`.`tId` = '" . $tId . "' 
ORDER BY `TD-Trasy`.`trPoradie`";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="containerT right">
              <div class="contentT">
                   <h2>' . $row['dMeno'] . '</h2>
                   <p>' . $row['dSprava'] . '<br>' . $row['trTimeSubmited'] . '</p>
              </div>
          </div>';
    }
} else {
  echo "Nebol pridaný tím. Pridajte tím stlačením tlačidla vyššie.";
}
mysqli_free_result($result);
mysqli_close($conn);

