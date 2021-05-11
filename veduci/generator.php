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
    <title>Robotika QR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/css.css">
    <link rel="manifest" href="/manifest.json">
    <style>
        .wrapper{padding: 20px;}
    </style>
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
    <br>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wrapper col-12 offset-md-2 col-md-8 text-center">
                    <h2>Vytvoriť trasu</h2>
                    <p>Pripravte si pre vaše tímy trasu s QR kódmi.</p>
                    <form>
                        <div class="mb-3 text-start">
                            <label for="name" class="form-label">Meno checkpointu</label>
                            <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3 text-start">
                            <label for="hint" class="form-label">Indícia</label>
                            <input type="text" class="form-control" id="hint">
                        </div>
                    </form>
                    <div class="text-end">
                        <button class="btn btn-success" id="create">Vytvoriť</button>
                        <button class="btn btn-primary" id="download">Stiahnúť</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 offset-md-2 col-md-8">
                <table class="table table-bordered">
                    <tbody id="tableElem">
                        <tr> <th>Číslo checkpointu</th> <th>Meno checkpointu</th> <th>Súbor</th> </tr>
                        <tr> <td>0</td> <td>Štart</td> <td>0_Štart.png</td> </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
    <script src="js/qr-gen.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous">
    </script>
</body>
</html>
