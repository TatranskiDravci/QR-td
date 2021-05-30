<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RobotikaQR - Login</title>
    <?php include('include/head.php');?>
</head>
<body>
<?php include('include/navbar.php');?>
<div class="container">
    <div class="row">
        <div class="col-12" id="mainbody" onclick="setwebcam()">
            <div id="outdiv"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="result"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <span class="pod-qr">Naskenujte QR kod na zaciatku v cieli a na konci.</span>
        </div>
    </div>
</div>
</body>
<?php include('include/js.php');?>
</html>