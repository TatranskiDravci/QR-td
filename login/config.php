<?php
define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'xxxxxx');
define('DB_PASSWORD', 'xxxxxx');
define('DB_NAME', 'f147316');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
  die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
