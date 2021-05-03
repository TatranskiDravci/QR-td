<?php
require "config.php";

$tim = $password = $confirm_password = "";
$tim_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["Akcia"]))) {
        $tim_err = "Prosim vytvorte meno tabulky.";
    } else {
        // Prepare a select statement
        $akcia = trim($_POST["Akcia"]);

        $sql = "SELECT 1 FROM " . $akcia;
        $result = $link->query($sql);

        if ($result == TRUE) {
            if (empty(trim($_POST["Tim"]))) {
                $tim_err = "Please enter a username.";
            } else {
                $sql = "SELECT tName FROM " . $akcia . " WHERE tName = ?";
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

                    // Close statement
                    $stmt->close();
                }
            }

            // Validate password
            if(empty(trim($_POST["Password"]))){
                $password_err = "Please enter a password.";
            } elseif(strlen(trim($_POST["Password"])) < 6){
                $password_err = "Password must have atleast 6 characters.";
            } else{
                $password = trim($_POST["Password"]);
            }

            // Check input errors before inserting in database
            if(empty($tim_err) && empty($password_err)){
                $sql = "INSERT INTO " . $akcia . " (tName, tHeslo) VALUES (?, ?)";

                if($stmt = $link->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("ss", $param_username, $param_password);

                    // Set parameters
                    $param_username = $tim;
                    $param_password = $password; // Creates a password hash

                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        // Redirect to login page
                        header("location: welcome.php");
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    $stmt->close();
                }
            }

            // Close connection
            $result->close();
            $link->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RobotikaQR - Registration</title>
    <style>
        .wrapper{padding: 20px;}
    </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="wrapper col-12 offset-md-2 col-md-8">
          <h2>Sign Up</h2>
          <p>Please fill this form to create an account.</p>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="usernameR" class="form-label">Nazov akcie</label>
              <input id="usernameR" type="text" name="Akcia" class="form-control <?php echo (!empty($akcia_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $akcia; ?>">
              <span class="invalid-feedback"><?php echo $akcia_err; ?></span>
            </div>
            <div class="form-group">
              <label for="passwordR" class="form-label">Meno timu</label>
              <input id="passwordR" type="text" name="Tim" class="form-control <?php echo (!empty($tim_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tim; ?>">
              <span class="invalid-feedback"><?php echo $tim_err; ?></span>
            </div>
            <div class="form-group">
              <label for="passwordCR" class="form-label">Heslo timu</label>
              <input id="passwordCR" type="password" name="Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>