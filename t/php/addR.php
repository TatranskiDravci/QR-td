<?php
$servername = "a043um.forpsi.com";
$username = "f147316";
$password = "S86FnMnR";
$dbname = "f147316";
$link = new mysqli($servername, $username, $password, $dbname);
if ($link->connect_error) {
  die("Connection failed: " . $link->connect_error);
}

//TODO prepisat do mysqli_...
$stmt = $link->prepare("UPDATE TestTable SET tCheckpoint = ?, tID = ?, tTime = ? WHERE tName = ?");
$stmt->bind_param("siss", $point, $IDcheck, $time, $name);

$point = $_REQUEST["name"];
$IDcheck = $_REQUEST["id"];
$time = date("Y-m-d H:i:s");
$name = $_SESSION["usernameT"];

$stmt->execute();
$stmt->close();
