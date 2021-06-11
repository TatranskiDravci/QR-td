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

// Display route of given team
$tId = $_GET['tId'];
$sql = "SELECT *
FROM `TD-TimyTrasy`
INNER JOIN `TD-Trasy` ON `TD-TimyTrasy`.`trId` = `TD-Trasy`.`trId`
INNER JOIN `TD-Qr` ON `TD-Trasy`.`trQrId` = `TD-Qr`.`dId`
WHERE `TD-TimyTrasy`.`tId` = '" . $tId . "' 
ORDER BY `TD-Trasy`.`trPoradie`";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  echo '<thead>
<tr>
  <th scope="col">Stanovisko</th>
  <th scope="col">Čas naskenovania</th>
  <th scope="col">Stav úlohy</th>
</tr>
</thead><tbody>';
  while ($row = mysqli_fetch_array($result)) {
    if ($row['trTuSme'] == 1) {
      $bodl = "noeHere";
    }
    else {
      $bodl = "";
    }
    echo '
<tr>
  <th scope="row" class="'. $bodl . '">' . $row['dMeno'] . '</th>
  <td>' . $row['trTimeSubmited'] . '</td>
  <td>' . $row['stav'] . '</td>
</tr>';
    }
    echo '</tbody>';
} else {
  echo "Nebol pridaný tím. Pridajte tím stlačením tlačidla vyššie.";
}
mysqli_free_result($result);
mysqli_close($conn);

/*
?>

<!--
<tr>
  <th class="noeHere" scope="row">Trete stanovisko</th>
  <td colspan="2">Čaká sa na tím</td>
</tr>-->