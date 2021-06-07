<?php
require_once "php/logged.php";
?>
<!DOCTYPE html>
<html lang="sk">
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Tatranskí dravci">
        <title>IDEM</title>
      <?php include "../include/head.php"; ?>
    </head>
	<body>
    <?php include "../include/nav_t.php"; ?>
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

		<script src="/t/js/qr-scanner/qr-scanner.umd.min.js"></script>
        <script src="js/handle.js"></script>
        <script src="js/ajax.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
                crossorigin="anonymous">
        </script>
        <script src="js/main.js"></script>
    </body>
</html>
