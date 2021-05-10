<?php
session_start();
if(!isset($_SESSION["loggedinM"]) || $_SESSION["loggedinM"] !== true){
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
            <a class="navbar-brand" href="/">IDEM&trade;</a>
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
                        <a class="nav-link" href="register.php">Pridať team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="generator.php">Vytvoriť trasu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tutorial.php">Ako to funguje</a>
                        <!--TODO vytvorit qr-code tutorial-->
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
            <div class="col-12 text-center">
                <h2>Sledovanie tímov</h2>
                <p>Tu nájdete kde sa vaše tímy nachádzajú.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="overflow-x: scroll;">
                <table class="table table-bordered t-content">
                    <thead>
                        <tr>
                            <th scope="col">Meno tímu</th>
                            <th scope="col">Číslo chcekpointu</th>
                            <th scope="col">Meno checkpointu</th>
                            <th scope="col">Čas pripojenia</th>
                            <th scope="col">Odstrániť team</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once "config.php";

                        $sql = "SELECT * FROM TestTable";
                        $result = $link->query($sql);
                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row['tName'] . "</td><td>" . $row['tID'] . "</td><td>" . $row['tCheckpoint'] . "</td><td>" . $row['tTime'] . "</td><td><a href='php/delete.php?id=" . $row['idTeams'] . "'>Vymazať tím</a></td></tr>";
                          }
                        } else {
                          echo "<tr><td>Nebol pridaný tím</td><td>Pridajte tím stlačením tlačidla vyššie.</td><td>-</td><td>-</td><td>-</td></tr>";
                          //TODO vlozit tlacidlo na vymazanie
                        }
                        $result->close();
                        $link->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous">
    </script>
</body>
</html>