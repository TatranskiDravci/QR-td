<?php
session_start();
if(!isset($_SESSION["loggedinT"]) || $_SESSION["loggedinT"] !== true){
  header("location: /team/login.php");
  exit;
}
require_once "connect.php";

$stmt = $link->prepare("UPDATE TestTable SET tCheckpoint = ? WHERE tName = ?;");
$stmt->bind_param("ssd", $point, $name);

$point = $_REQUEST["name"];
$name = $_SESSION["usernameT"];

$stmt->execute();
$stmt->close();

echo "OK";/*

$sql = "SELECT * FROM connT";
$result = $link->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row["users"] . $row["zaznamy"];
  }
} else {
  echo "0 results";
}
$result->close();

$link->close();

echo "hotovo";*/
