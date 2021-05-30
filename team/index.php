<?php
session_start();
if(!isset($_SESSION["loggedinT"]) || $_SESSION["loggedinT"] !== true){
  header("location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="sk">
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Tatranskí dravci">
        <title>IDEM&trade;</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
              rel="stylesheet"
              integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
              crossorigin="anonymous">
        <link rel="stylesheet" href="/css.css">
        <link rel="manifest" href="/manifest.json">
    </head>
	<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <img src="/idem.png" alt="IDEM" height="30">
                </a>
                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="tutorial.php">Ako to funguje?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Odhlásiť sa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-12 offset-md-2 col-md-8 text-center">
                    <h2><?php echo $_SESSION["usernameT"];?></h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <video id="videoElem"></video>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-10">
                    <p id="distance"></p>
                    <table class="table table-bordered">
                        <tbody id="tableElem">
                            <!-- TODO cookies sa ukladaju samostatne a ked sa odhlasim a prihlasim tak sa nevymazu -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

		<script src="/team/js/qr-scanner/qr-scanner.umd.min.js"></script>
        <script src="js/handle-qr.js"></script>
        <script src="js/ajax.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
                crossorigin="anonymous">
        </script>
        <script src="js/worker.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
