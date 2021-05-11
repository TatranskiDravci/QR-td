<?php
session_start();
if(isset($_SESSION["loggedinT"]) && $_SESSION["loggedinT"] === true){
  header("location: index.php");
  exit;
}
require_once "php/connect.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Prosím napíšte meno Vášho tímu.";
  } else{
    $username = trim($_POST["username"]);
  }

  if(empty(trim($_POST["password"]))){
    $password_err = "Prosím napíšte heslo Vášho tímu.";
  } else{
    $password = trim($_POST["password"]);
  }

  if(empty($username_err) && empty($password_err)){
    $sql = "SELECT tName, tHeslo FROM TestTable WHERE (tName = ? AND tHeslo = ?) ";

    if($stmt = $link->prepare($sql)){
      $stmt->bind_param("ss", $param_username, $param_password);
      $param_username = $username;
      $param_password = $password;

      if($stmt->execute()){
          $stmt->store_result();
          if($stmt->num_rows() == 1) {
            session_start();
            $_SESSION["loggedinT"] = true;
            $_SESSION["usernameT"] = $username;
            header("location: index.php");
          } else {
              $login_err = "Invalid username or password.";
          }
      } else{
          // Username doesn't exist, display a generic error message
          $login_err = "Invalid username or password.";
      }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

      // Close statement
    $stmt->close();
    $link->close();
  }
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
        .navbar>.container-fluid {justify-content: center;}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand h1" href="/" style="margin: 0;padding: 0">
            <img src="/idem.png" alt="IDEM" height="40">
        </a>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="wrapper col-12 offset-md-2 col-md-8 text-center">
                <h2>Prihlásenie - Tím</h2>
                <p>Prosím vyplnte prihlasovacie údaje vášho tímu.<br>Bude stačiť pokiaľ sa prihlási iba jeden z Vášho tímu.</p>
                <?php
                if(!empty($login_err)){
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="mb-3 text-start">
                        <label for="username" class="form-label">Meno tímu:</label>
                        <input id="username"
                               type="text"
                               name="username"
                               class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Heslo:</label>
                        <input id="password"
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