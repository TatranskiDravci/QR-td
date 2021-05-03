<?php
$servername = "a043um.forpsi.com";
$username = "xxxxxx";
$password = "Xxxxxxxx";
$dbname = "f147316";

// Create connection
$link = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($link->connect_error) {
  die("Connection failed: " . $link->connect_error);
}
