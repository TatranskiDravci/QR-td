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
    <style>
        .nav-tabs {
            background-color: #ffffff;
            position: absolute;
            left: 0;
            right: 0;
            overflow-x: scroll;
        }
        .nav-link {
            color: #5fb865;
            font-weight: 650;
            text-decoration: underline;
        }
        .timeline {
            position: relative;
            margin: 42px auto auto;
        }
        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: white;
            top: 0;
            bottom: 0;
            left: 31px;
            margin-left: -3px;
        }
        .containerT::before {
            left: 60px;
            border: medium solid white;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }
        .containerT {
            width: 100%;
            padding: 10px 25px 10px 70px;
            position: relative;
            background-color: inherit;
        }
        .containerT::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            background-color: white;
            border: 4px solid #5fb865;
            top: 50%;
            border-radius: 50%;
            z-index: 1;
            transform: translateY(-50%);
        }
        .right {
            left: 0;
        }
        .right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 50%;
            width: 0;
            z-index: 1;
            border: medium solid white;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
            transform: translateY(-50%);
        }
        .right::after {
            left: 18px;
        }
        .contentT {
            padding: 20px 30px;
            background-color: white;
            position: relative;
            border-radius: 6px;
        }
    </style>
</head>
<body style="background-color: #272b38">
    <?php include '../include/nav_v.php';?>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center" style="background-color: #ffffff; padding-top: 10px;">
                <h2>Sledovanie tímov</h2>
                <p>Tu nájdete kde sa vaše tímy nachádzajú.</p>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <?php
            define('DB_SERVER', 'a043um.forpsi.com');
            define('DB_USERNAME', 'f147316');
            define('DB_PASSWORD', 'S86FnMnR');
            define('DB_NAME', 'f147316');
            $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if($conn === false) {
              die('Connect Error: ' . mysqli_connect_error());
            }
            $sql = "SELECT *
FROM `TD-VeduciTimy`
INNER JOIN `TD-Timy` ON `TD-VeduciTimy`.`tId` = `TD-Timy`.`tId`
WHERE `TD-VeduciTimy`.`vId` = '" . $_SESSION["vId"] . "' ";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<li class="nav-item">
                <a class="nav-link" aria-current="page" tid="#'. $row['tId'] .'">'. $row['tMeno'] .'</a>
            </li>';
              }
            } else {
              echo "Nebol pridaný tím. Pridajte tím stlačením tlačidla vyššie.";
            }
            mysqli_free_result($result);
            mysqli_close($conn);
            ?>
        </ul>
        <div class="row">
            <div class="col-12">
                <div class="timeline">
                  <?php
                  define('DB_SERVER', 'a043um.forpsi.com');
                  define('DB_USERNAME', 'f147316');
                  define('DB_PASSWORD', 'S86FnMnR');
                  define('DB_NAME', 'f147316');
                  $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                  if($conn === false) {
                    die('Connect Error: ' . mysqli_connect_error());
                  }

                  $tId = 'asdsadsadsadsddd'/*cez funkciu GET a requesty*/;
                  $sql = "SELECT *
FROM `TD-TimyTrasy`
INNER JOIN `TD-Trasy` ON `TD-TimyTrasy`.`trId` = `TD-Trasy`.`trId`
INNER JOIN `TD-Qr` ON `TD-Trasy`.`trQrId` = `TD-Qr`.`dId`
WHERE `TD-TimyTrasy`.`tId` = '" . $tId . "' 
ORDER BY `TD-Trasy`.`trPoradie`";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo '<div class="containerT right">
                        <div class="contentT">
                            <h2>'. $row['dMeno'] .'</h2>
                            <p>'. $row['trTimeSubmited'] .' '. $row['dSprava'] .'</p>
                        </div>
                    </div>';
                    }
                  } else {
                    echo "Nebol pridaný tím. Pridajte tím stlačením tlačidla vyššie.";
                  }
                  mysqli_free_result($result);
                  mysqli_close($conn);
                  ?>
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
