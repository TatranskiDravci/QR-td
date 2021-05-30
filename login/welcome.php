<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RobotikaQR - Welcome</title>
    <?php include('../include/head.php');?>
    <style>
      body{text-align: center; }
    </style>
</head>
<body>
<?php include('../include/navbar.php');?>
<h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
<p>
  <a href="reset-password.php" class="btn btn-warning">Reset Your Passworassword Sign Od</a>
  <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</p>
</body>
<?php include('../include/js.php');?>
</html>