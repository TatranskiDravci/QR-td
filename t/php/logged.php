<?php
session_start();
if(!isset($_SESSION["tLoggedIn"]) || $_SESSION["tLoggedIn"] !== true){
  header("location: https://".$_SERVER['HTTP_HOST']."/login.php");
  exit;
}