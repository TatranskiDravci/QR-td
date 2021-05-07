<?php
session_start();
if(!isset($_SESSION["loggedinT"]) || $_SESSION["loggedinT"] !== true){
  header("location: /team/login.php");
  exit;
}
require_once "connect.php";

$stmt = $link->prepare("UPDATE TestTable SET tCheckpoint = ?, tID = ? WHERE tName = ?");
$stmt->bind_param("sis", $point, $IDcheck, $name);

$point = $_REQUEST["name"];
$IDcheck = $_REQUEST["id"];
$name = $_SESSION["usernameT"];

$stmt->execute();
$stmt->close();
