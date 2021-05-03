<?php
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: /login/login.php");
  exit;
}
require_once "connect.php";
require_once('../Hashids/HashGenerator.php');
require_once('../Hashids/Hashids.php');

$stmt = $link->prepare("INSERT INTO zaznamy (hash, cesta, km) VALUES (?, ?, ?);");
$stmt->bind_param("ssd", $cesta, $km);

$cesta = $_REQUEST["c"];
$km = $_REQUEST["km"];

//$hash = hash ( 'md5' , $id , double $binary = false );

$stmt->execute();
$stmt->close();

$stmt = $link->prepare("INSERT INTO zaznamy (hash) VALUES (?, ?)");
$stmt->bind_param("sd", $cesta, $km);

$hashids = new Hashids\Hashids('Testing Testiing', 10);
$id = $hashids->encode(1337);
var_dump($id);

$stmt->execute();
$stmt->close();

$stmt = $link->prepare("INSERT INTO connT (users, zaznamy) VALUES (?, ?);");
$stmt->bind_param("ii", $UserH, $ZaznamyH);

$UserH = $_SESSION["id"];
$ZaznamyH =  $link->insert_id;

echo $UserH;

//$hash = hash ( 'md5' , $id , double $binary = false );

$stmt->execute();
$stmt->close();

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

echo "hotovo";
