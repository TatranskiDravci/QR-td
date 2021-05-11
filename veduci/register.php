<?php
require "php/connect.php";

$tim = $password = "";
$tim_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["Tim"]))) {
        $tim_err = "Please enter a username.";
    } else {
        $sql = "SELECT tName FROM TestTable WHERE tName = ?";
        if($stmt = $link->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["Tim"]);

            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows() == 1){
                    $tim_err = "This username is already taken.";
                } else{
                    $tim = trim($_POST["Tim"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["Password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["Password"])) < 3) {
        $password_err = "Password must have at least 3 characters.";
    } else {
        $password = trim($_POST["Password"]);
    }

    // Check input errors before inserting in database
    if(empty($tim_err) && empty($password_err)){
        $sql = "INSERT INTO TestTable (tName, tHeslo) VALUES (?, ?)";

        if($stmt = $link->prepare($sql)){
            $stmt->bind_param("ss", $param_tim, $param_password);
            $param_tim = $tim;
            $param_password = $password;

            if($stmt->execute()){
                header("location: index.php");
            } else {
                echo "Ooops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

           /* // Close connection
            $result->close();
            $link->close();
        }
    }*/
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
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wrapper col-12 offset-md-2 col-md-8 text-center">
                    <h2>Nový tím</h2>
                    <p>Tu môžete pridať nový tím!</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3 text-start">
                            <label for="passwordR" class="form-label">Meno tímu:</label>
                            <input id="passwordR"
                                   type="text"
                                   name="Tim"
                                   class="form-control <?php echo (!empty($tim_err)) ? 'is-invalid' : ''; ?>"
                                   value="<?php echo $tim; ?>">
                            <span class="invalid-feedback"><?php echo $tim_err; ?></span>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="passwordCR" class="form-label">Heslo tímu:</label>
                            <input id="passwordCR"
                                   type="password"
                                   name="Password"
                                   class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                   value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="mb-3 form-check text-end">
                            <button type="submit" class="btn btn-primary" value="Submit">Potvrdiť</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous">
    </script>
</body>
</html>