<?php
  session_start();
  require("config.php");
  if (isset($_POST["resetPassword"])) {
    $email = stripcslashes($_POST["email"]);
    $emailQuery= "SELECT * FROM `users` WHERE email='$email'";
    $result = $conn->query($emailQuery);
    if ($result->num_rows > 0) {
      $expiry_date = date(
        "Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"))
      );
      $token = sha1($email . date_format(date_create("now"), "Y-m-d H:i:s"));
      $query = "INSERT into `password_reset` (email, token, expiry_date) VALUES
        ('$email', '$token', '$expiry_date')";
      if ($conn->query($query) === TRUE) {
        $_POST = NULL;
        $msg = "You have requested a password reset for your Leave-MS account.\n";
        $msg .= "Follow the link below to set a new password:\n\n";
        $msg .= "localhost/leave-ms/reset-password.php?token=" . $token . "&email=" . $email . "&action=reset";
        $msg .= "\n\nIf you don't wish to reset your password, disregard this email and no action will be taken.";
        mail($email, "Reset your Leavse-MS password", $msg);
        header("location: forgot-password-done.php");
      } elseif (strpos($conn->error, "'email'") > 0) {
        $deleteQuery = "DELETE FROM `password_reset` WHERE email='$email'";
        if ($conn->query($deleteQuery) === TRUE) {
          if ($conn->query($query) === TRUE) {
            $_POST = NULL;
            $msg = "You have requested a password reset for your Leave-MS account.\n";
            $msg .= "Follow the link below to set a new password:\n\n";
            $msg .= "localhost/leave-ms/reset-password.php?token=" . $token . "&email=" . $email . "&action=reset";
            $msg .= "\n\nIf you don't wish to reset your password, disregard this email and no action will be taken.";
            mail($email, "Reset your Leavse-MS password", $msg);
            header("location: forgot-password-done.php");
          }
        }
      }
    } else {
      header("location: forgot-password-done.php");
    }
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
        <div class="col-5 mx-auto">
          <div class="card border-0 shadow-lg">
            <div class="card-body">
              <div class="row pb-5 pt-4">
                <div class="col-11 mx-auto">
                  <div class="text-center">
                    <h3>Reset your password</h3>
                    <small>Enter your email address and we will send you a link to reset your password.</small>
                  </div>
                  <form class="pt-4" method="post">
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="email" name="email" required="" class="form-control">
                    </div>
                    <div class="py-3">
                      <button class="col-12 btn btn-dark" name="resetPassword">
                        SEND PASSWORD RESET EMAIL
                      </button>
                    </div>
                  </form>
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