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
        <link rel="stylesheet" href="/include/css/css.css">
    </head>
	<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Robotika QR</a>
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
                            <a class="nav-link" aria-current="page" href="#">Moje záznamy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ako to funguje</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Prihlásiť sa</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center" style="height: 90vh;background-color: #272b38; color: #ffffff;">
                    <div style="position: absolute;top: 50%; left: 50%; transform: translate(-50%, -50%);">
                        <a href="team/login.php" class="btn btn-primary ml-3" style="background-color: #5fb865;border-color: #5fb865;margin-bottom: 30px;">Prihlásiť sa ako tím.</a><br>
                        <a href="mentor/login.php" class="btn btn-primary ml-3" style="background-color: #5fb865;border-color: #5fb865;">Prihlásiť sa ako Vedúci.</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 pt-5 pb-5 px-5 text-center" style="background-color: #ddd; color: #000000;">
                    <h2 style="color: #5fb865;">Info o stránke</h2>
                    <p>Ak vytvárate tímové aktivity a potrebujete zistiť ako tímy postupujú či im chcete zanechať správu / indíciu na konkrétnych miestach, tak ste tu správne!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 pt-5 pb-5 px-5 text-center" style="background-color: #272b38; color: #ffffff;">
                    <h2 style="color: #5fb865;">Vytváram aktivitu</h2>
                    <p>Vytvorte pre vaše tímy inetraktívnu trasu pomocov QR kódov generovaných na našej stránke. Vaše tímy si na vami určených miestach - chcekpointoch naskenujú QR kód. Kód im môže ukázať aj správu či indíciu na daľšie miesto, pretože použitie je na vás. Akonáhle tím naskenuje QR kód vy budete vidieť na ktorom checkpointe sa tím nachádza.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 pt-5 pb-5 px-5 text-center" style="background-color: #dddddd; color: #000000;">
                    <h2 style="color: #5fb865;">Som v tíme</h2>
                    <p>Proces je jednoduchý! Prihláste sa pomocov údajov ktoré vám vytvorí váš vedúci. Potom si na každom chceckpointe naskenujte qr kód a HOTOVO! Váš vedúci vidí váš progres.</p>

                    <a href="#" class="btn btn-primary ml-3" style="background-color: #5fb865;border-color: #5fb865;">Odhlásiť sa</a>
                    <span> | </span>
                    <a href="#" class="btn btn-primary ml-3" style="background-color: #5fb865;border-color: #5fb865;">Pridať tím</a>
                </div>
            </div>
        </div>

		<script src="include/qr-scanner/qr-scanner.umd.min.js"></script>
		<script src="distance-table.js"></script>
        <script src="handle-qr.js"></script>
        <script src="ajax.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
                crossorigin="anonymous">
        </script>
    </body>
</html>
