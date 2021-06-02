<?php
define('DB_SERVER', 'a043um.forpsi.com');
define('DB_USERNAME', 'f147316');
define('DB_PASSWORD', 'S86FnMnR');
define('DB_NAME', 'f147316');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false) {
  die('Connect Error: ' . mysqli_connect_error());
}
