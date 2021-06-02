<?php
require 'php/logged.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDEM</title>
    <?php include '../include/head.php'; ?>
</head>
<body>
    <?php include '../include/nav_v.php';?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Sledovanie tímov</h2>
                <p>Tu nájdete kde sa vaše tímy nachádzajú.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="overflow-x: scroll;">
              <?php include "php/table.php"; ?>
                <!--<table class="table table-bordered t-content">
                    <thead>
                        <tr>
                            <th scope="col">Meno tímu</th>
                            <th scope="col">Číslo chcekpointu</th>
                            <th scope="col">Meno checkpointu</th>
                            <th scope="col">Čas pripojenia</th>
                            <th scope="col">Odstrániť team</th>
                        </tr>
                    </thead>
                    <tbody id="tableElem">

                    </tbody>
                </table>-->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
    </script>
    <script src="js/table.js"></script>
</body>
</html>
