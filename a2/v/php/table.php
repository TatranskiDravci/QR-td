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
    echo '
    <div class="card text-center" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div><a href="php/delete.php?id="'/*. $row['idTeams']*/ . '">Vymazať tím</a></td></tr>';
  }
} else {
  echo "Nebol pridaný tím. Pridajte tím stlačením tlačidla vyššie.";
}
$result->close();
$conn->close();


