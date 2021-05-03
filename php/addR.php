<?php
require_once "connect.php";
$stmt = $link->prepare("INSERT INTO zaznamy (cesta, km) VALUES (?, ?)");
$stmt->bind_param("sd", $cesta, $km);

$cesta = $_REQUEST["c"];
$km = $_REQUEST["km"];

//$hash = hash ( 'md5' , $id , double $binary = false );

$stmt->execute();
$stmt->close();
$link->close();

echo "hotovo";
