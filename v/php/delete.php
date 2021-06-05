<?php
//TODO add function for deleting expeditions using this base form before
session_start();
if(!isset($_SESSION["loggedinM"]) || $_SESSION["loggedinM"] !== true){
  header("location: /veduci/login.php");
  exit;
}
require_once "connect.php";

$stmt = $link->prepare("DELETE FROM TestTable WHERE idTeams = ?");
$stmt->bind_param("i", $tid);

$tid = $_REQUEST["id"];

$stmt->execute();
$stmt->close();
header("location: /veduci/");