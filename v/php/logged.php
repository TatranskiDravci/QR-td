<?php
session_start();
if(!isset($_SESSION["vLoggedIn"]) || $_SESSION["vLoggedIn"] !== true){
  header("location: https://".$_SERVER['HTTP_HOST']."/a2/v/");
  exit;
}