<?php
session_start();

if(isset($_SESSION["loggedinM"]) && $_SESSION["loggedinM"] === true){
  header("location: welcome.php");
  exit;
}

$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        if ($username == "Mentor" && $password == "Mentorove*Heslo") {
            session_start();
            $_SESSION["loggedinM"] = true;
            header("location: welcome.php");
        } else {
          $login_err = "Meno alebo heslo nie je správne.";
        }
    }
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
    <style>
      .wrapper{padding: 20px;}
    </style>
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
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wrapper col-12 offset-md-2 col-md-8 text-center">
                    <h2>Prihlásenie - Mentor</h2>
                    <p>Prosím vyplnte vaše prihlasovacie údaje.</p>
                    <?php
                    if(!empty($login_err)){
                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3 text-start">
                            <label for="usernameL" class="form-label">Prihlasovacie meno:</label>
                            <input id="usernameL"
                                   type="text"
                                   name="username"
                                   class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                                   value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="passwordL" class="form-label">Heslo:</label>
                            <input id="passwordL"
                                   type="password"
                                   name="password"
                                   class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="mb-3 form-check text-end">
                            <button type="submit" class="btn btn-primary" value="login">Potvrdiť</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>