<?php
require "connect.php";

$sql = "SELECT * FROM TestTable";
$result = $link->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row['tName'] . "</td><td>" . $row['tID'] . "</td><td>" . $row['tCheckpoint'] . "</td><td>" . $row['tTime'] . "</td><td><a href='php/delete.php?id=" . $row['idTeams'] . "'>Vymazať tím</a></td></tr>";
  }
} else {
  echo "<tr><td>Nebol pridaný tím</td><td>Pridajte tím stlačením tlačidla vyššie.</td><td>-</td><td>-</td><td>-</td></tr>";
  //TODO vlozit tlacidlo na vymazanie
}
$result->close();
$link->close();


