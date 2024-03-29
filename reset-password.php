<?php
  session_start();
  require("config.php");
  $email = stripcslashes($_GET["email"]);
  $token = stripcslashes(($_GET["token"]));
  $action = stripcslashes($_GET["action"]);
  $now = date_format(date_create("now"), "Y-m-d H:i:s");
  $query = "SELECT * FROM `password_reset` WHERE token='$token' AND email='$email' AND expiry_date>='$now'";
  $result = $conn->query($query);
  if (($result->num_rows > 0) && ($action == "reset")) {
    if (isset($_POST["resetPassword"])) {
      $pass1 = stripcslashes($_POST["password1"]);
      $pass2 = stripcslashes($_POST["password2"]);
      if (empty($pass1)) {
        $_SESSION["pass1Empty"] = true;
      }
      if (empty($pass2)) {
        $_SESSION["pass2Empty"] = true;
      }
      if ($pass1 != $pass2) {
        $_SESSION["passNotMatch"] = true;
      } elseif (isset($_POST["password1"], $_POST["password2"]) && ($pass1 === $pass2)) {
        $password = password_hash($pass1, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE `users` SET password='$password' WHERE email='$email'";
        if ($conn->query($updatePasswordQuery) === TRUE) {
          $_POST = NULL;
          $passwordResetQuery = "DELETE FROM `password_reset` WHERE email='$email'"; // Delete PassReset entry
          if ($conn->query($passwordResetQuery) === TRUE) {
            header("location: reset-password-done.php");
          }
        }
      }
    }
  } else {
    $_SESSION["invalidLink"] = true;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Reset your password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <script src="static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="static/js/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php include('includes/home_nav.php'); ?>
    <div class="container">
      <div class="row py-5">
        <div class="col-6 mx-auto">
          <div class="card border-0 shadow-lg">
            <div class="card-body">
              <div class="row pb-5 pt-4">
                <div class="col-11 mx-auto">
                  <?php if (!isset($_SESSION["invalidLink"])): ?>
                    <div class="text-center">
                      <h3>Reset your password</h3>
                      <small>Please enter (and confirm) your new password.</small>
                    </div>
                    <form class="pt-3" method="post">
                      <div class="form-group">
                        <label>New password:</label>
                        <input type="password" name="password1" required="" value="<?php if (isset($_POST['password1'])) {echo($_POST['password1']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["pass1Empty"]) && ($_SESSION["pass1Empty"] === true)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["pass1Empty"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>Confirm new password:</label>
                        <input type="password" name="password2" required="" value="<?php if (isset($_POST['password2'])) {echo($_POST['password2']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["pass2Empty"]) && ($_SESSION["pass2Empty"] === true)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["pass2Empty"] = NULL;
                          } elseif (isset($_SESSION["passNotMatch"]) && ($_SESSION["passNotMatch"] === true)) {
                            echo '<small class="text-danger"><strong>Passwords do not match!<br>Both passwords must be the same</strong></small>';
                            $_SESSION["passNotMatch"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="py-3">
                        <button class="col-12 btn btn-dark" name="resetPassword">
                          RESET PASSWORD 
                        </button>
                      </div>
                    </form>
                  <?php else: $_SESSION["invalidLink"] = NULL; ?>
                    <div class="py-3">
                      <h2 class="text-center">Password Reset Failed!</h2>
                    </div>
                    <div class="pt-2">
                      <p>The password reset link is invalid, possibly because it has already been used or it has expired.</p>
                      <p>Please request a new password reset.</p>
                      <a class="btn btn-dark btn-sm" href="forgot-password.php">RESET PASSWORD</a>
                    </div>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <style>
    body {
      background-color: #f4f3f4;
    }
  </style>
</html>