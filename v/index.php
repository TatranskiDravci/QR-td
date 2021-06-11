<?php
require_once "php/logged.php";
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDEM</title>
    <?php include "../include/head.php"; ?>
    <style>
        body {
            box-sizing: content-box;
            background-color: #f8f9fa;
        }
        h2 {
            color: #5fb865;
        }
        .containerINFO {
            background-color: #f8f9fa;
            width: 100%;
            padding-right: var(--bs-gutter-x,.75rem);
            padding-left: var(--bs-gutter-x,.75rem);
            margin-right: auto;
            margin-left: auto;
        }
        .nav-tabs {
            background-color: #ffffff;
            width: 100%;
        }
        .nav-link {
            color: #5fb865;
            font-weight: 650;
            text-decoration: underline;
        }
        .info-top {
            width: 100%;
            background-color: #ffffff;
            padding: 10px;
        }
        .info-top {
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px;
        }
        .obsah {
            background-color: rgb(255, 255, 255);
            width:100%;
            border-bottom-color: #5fb865;
            border-bottom-style: solid;
            border-width: 0 0 2px;
            padding: .5rem 2rem  1rem;
        }
        .obsah .nadpisy {
            width:100%;
        }
        tbody th {
            font-weight: normal;
        }
        .noeHere{
            font-weight: bold;
        }
        .list-group-flush>.list-group-item {
            border-width: 0 0 2px;
        }
        .list-group-item {
            border: 1px solid #5fb865;
        }
        .list-group-item svg:first-child {
            position: absolute;
            right: 0;
        }
        .ctr {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body style="background-color: #272b38">
<?php include "../include/nav_min.php";?>
<div class="containerINFO">
    <div class="row">
        <div class="col-12 text-center info-top">
            <h2>Sledovanie tímov</h2>
            <p>Tu nájdete kde sa vaše tímy nachádzajú.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="col-8 ctr" style="margin-top: 20px;">
                <ul class="list-group list-group-flush">
                  <?php
                  define('DB_SERVER', 'a043um.forpsi.com');
                  define('DB_USERNAME', 'f147316');
                  define('DB_PASSWORD', 'S86FnMnR');
                  define('DB_NAME', 'f147316');
                  $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                  if($conn === false) {
                    die('Connect Error: ' . mysqli_connect_error());
                  }

                  // Display expeditions
                  $sql = "SELECT *
                            FROM `TD-VeduciTimy`
                            INNER JOIN `TD-Timy` ON `TD-VeduciTimy`.`tId` = `TD-Timy`.`tId`
                            WHERE `TD-VeduciTimy`.`vId` = '" . $_SESSION["vId"] . "' 
                            ORDER BY `TD-Timy`.`tMeno`";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '<a href="?tId='. $row['tId'] .'" class="list-group-item fs-2">'. $row['tMeno'] .'
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 0 24 24" width="48px" fill="#000000"><path d="M24 24H0V0h24v24z" fill="none" opacity=".87"/><path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6-1.41-1.41z"/></svg>
                    </a>
                    <div id="'. $row['tId'] .'" class="obsah" style="display: none;">
                        <table class="table timeline" id="timeline">
                        </table>
                        <div class="fs-6 nadpisy">Aktuálne stanovisko je zvýraznené <b>Hrubým</b>.</div>
                    </div>';
                    }
                  } else {
                    echo "Zatiaľ nebol pridaný žiadny tím. <a href='generator.php'>Pridať tím</a>";
                  }
                  mysqli_free_result($result);
                  mysqli_close($conn);
                  ?>
                </ul>
            </div>
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

