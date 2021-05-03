<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedinM"]) || $_SESSION["loggedinM"] !== true){
  header("location: login.php");
  exit;
}

require_once "config.php";

$sql = "SELECT * FROM TestTable";
$result = $link->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo $row["tName"] . " - " . $row["tCheckpoint"] . "<br>";
  }
} else {
  echo "0 results";
}
$result->close();
$link->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RobotikaQR - Welcome</title>
    <style>
      body{text-align: center; }
    </style>
</head>
<body>
    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    <a href="register.php" class="btn btn-danger ml-3">Nova aktivita</a>
</body>
</html>