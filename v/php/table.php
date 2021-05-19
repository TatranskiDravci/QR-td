<?php
define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'f147316');
define('DB_PASSWORD', 'S86FnMnR');
define('DB_NAME', 'f147316');
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($conn === false) {
  die('Connect Error: ' . mysqli_connect_error());
}

$vId = $_SESSION["vId"];
$sql = "SELECT `timyDB`.* FROM `timyDB` JOIN `VeduciTimyDB` ON `timyDB`.`DBtId` = `VeduciTimyDB`.`DBtId` WHERE `VeduciTimyDB`.`DBvId` = '" . $vId ."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['DBtMeno'] . "</td><td>" . $row['DBtId'] . "</td><td>" . $row['DBtPMeno'] . "</td><td>" . $row['DBtPHeslo'] . "</td><td><a href='php/delete.php?id=" /*. $row['idTeams']*/ . "'>Vymazať tím</a></td></tr>";
  }
} else {
  echo "<tr><td>Nebol pridaný tím</td><td>Pridajte tím stlačením tlačidla vyššie.</td><td>-</td><td>-</td><td>-</td></tr>";
}
$result->close();
$conn->close();


