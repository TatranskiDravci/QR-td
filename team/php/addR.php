<?php
session_start();
if(!isset($_SESSION["loggedinT"]) || $_SESSION["loggedinT"] !== true){
  header("location: /team/login.php");
  exit;
}
require_once "connect.php";

$stmt = $link->prepare("UPDATE TestTable SET tCheckpoint = ?, tID = ?, tTime = ? WHERE tName = ?");
$stmt->bind_param("siss", $point, $IDcheck, $time, $name);

$point = $_REQUEST["name"];
$IDcheck = $_REQUEST["id"];
$time = date("Y-m-d H:i:s");
$name = $_SESSION["usernameT"];

$stmt->execute();
$stmt->close();
