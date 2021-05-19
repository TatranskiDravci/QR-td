<?php
session_start();
if(!isset($_SESSION["vLoggedIn"]) || $_SESSION["vLoggedIn"] !== true){
  header("location: login.php");
  exit;
}