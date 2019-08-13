<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staff = $_SESSION['staff_pin'];
    $query = "SELECT password FROM `users` WHERE staff_pin='$staff'";
    $result = $conn->query($query);
    if (isset($_POST["changePassword"])) {
      if (empty($_POST["oldPassword"])) {
        $_SESSION["oldPassError"] = true;
      }
      if (empty($_POST["newPassword"])) {
        $_SESSION["newPassError"] = true;
      } elseif ($_POST["newPassword"] == $_POST["oldPassword"]) {
        $_SESSION["samePassError"] = true;
      } else {
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $oldPassword = $_POST["oldPassword"];
          $newPassword = $_POST["newPassword"];
          if (password_verify($oldPassword, $row["password"])) {
            $changePasswordQuery = "UPDATE `users` SET password='$newPassword' WHERE staff_pin='$staff'";
            if ($conn->query($changePasswordQuery) === TRUE) {
              $_SESSION["passwordChanged"] = true;
              $_POST = NULL;
              echo "Changed!";
            }
          } else {
            $_SESSION["wrongPassError"] = true;
          }
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="dashboard.php">Leave MS</a>
      <ul class="navbar-nav offset-md-8 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="profile.php">My profile</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 mx-auto">
          <div class="row py-5">
            <div class="col-sm-12 col-md-10 mx-auto">
              <div class="card shadow-lg border-0">
                <div class="card-header">
                  <h3>
                    Change Password
                  </h3>
                </div>
                <div class="card-body">
                <?php
                  if (isset($_SESSION["samePassError"]) && ($_SESSION["samePassError"] === TRUE)) {
                    echo '<div class="alert alert-danger alert-dismissible text-center my-3"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>New password cannot be same as the old password!</strong></div>';
                    $_SESSION["samePassError"] = NULL;
                  }
                ?>
                  <form method="post">
                    <div class="form-group">
                      <label>Old password:</label>
                      <input type="password" required="" name="oldPassword" class="form-control">
                      <?php
                        // Catch empty field error
                        if (isset($_SESSION["oldPassError"]) && ($_SESSION["oldPassError"] === TRUE)) {
                          echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          $_SESSION["oldPassError"] = NULL;
                        } elseif (isset($_SESSION["wrongPassError"]) && ($_SESSION["wrongPassError"] === TRUE)) {
                          echo '<small class="text-danger"><strong>You have entered the wrong password!</strong></small>';
                          $_SESSION["wrongPassError"] = NULL;
                        }
                      ?>
                    </div>
                    <div class="form-group">
                      <label>New password:</label>
                      <input type="password" required="" name="newPassword" class="form-control">
                      <?php
                        // Catch empty field error
                        if (isset($_SESSION["newPassError"]) && ($_SESSION["newPassError"] === TRUE)) {
                          echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          $_SESSION["newPassError"] = NULL;
                        }
                      ?>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer border-0">
                      <a class="btn btn-outline-secondary" href="profile.php">
                        CANCEL
                      </a>
                      <button class="btn btn-dark" name="changePassword">
                        CHANGE PASSWORD
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
      background-color: #f4f3f4 !important;
    }
  </style>
</html>