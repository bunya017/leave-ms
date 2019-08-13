<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <script src="static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="static/js/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php
      session_start();
      require("config.php");
      if (isset($_POST["submit"])) {
        if (empty($_POST["email"]) === TRUE) {
          $_SESSION["emailError"] = true;
          session_destroy();
        } elseif (empty($_POST["password"]) === TRUE) {
          $_SESSION["passwordError"] = true;
          session_destroy();
        } elseif (isset($_POST["email"]) === TRUE and isset($_POST["email"]) === TRUE) {
          $email = stripcslashes($_POST["email"]);
          $password = stripcslashes($_POST["password"]);
          $query = "SELECT * FROM `users` WHERE email='$email'";
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"]) === TRUE) {
              $_SESSION["first_name"] = $row["first_name"];
              $_SESSION["last_name"] = $row["last_name"];
              $_SESSION["staff_pin"] = $row["staff_pin"];
              $_SESSION["isLoggedIn"] = true;
              $role_id = $row["role_id"];
              $role_sql = "SELECT * FROM `roles` WHERE id='$role_id'";
              $role_query = $conn->query($role_sql);
              $role_row = $role_query->fetch_assoc();
              $_SESSION["role"] = $role_row["name"];
              $_SESSION["can_forward_to_director"] = $role_row["can_forward_to_director"];
              $_SESSION["can_forward_to_registrar"] = $role_row["can_forward_to_registrar"];
              if ($role_row["name"] === "staff") {
                header("location: staff/dashboard.php");
              } elseif ($role_row["name"] === "director" or "registrar" or "head_ict") {
                header("location: admin/dashboard.php");
              } else {
                echo $conn->connect_error . "<br>";
              }
            } else {
              $_SESSION["loginError"] = true;
              session_destroy();
            }
          } else {
            $_SESSION["loginError"] = true;
            session_destroy();
          }
        }
      }
    ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-5" href="">
        Leave MS
      </a>
    </nav>
    <div class="container">
      <div class="row py-5">
        <div class="col-5 mx-auto">
          <div class="card border-0 shadow-lg">
            <div class="card-body">
              <div>
                <h3 class="text-center">Login</h3>
              </div>
              <?php
                if (isset($_SESSION["loginError"])) {
                  if ($_SESSION["loginError"] === true) {
                    echo '<div class="alert alert-danger mt-4 alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Incorrect email or password!</strong></div>';
                  }
                }
              ?>
              <div class="row pb-5 pt-4">
                <div class="col-11 mx-auto">
                  <form method="post">
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="email" name="email" required="" value="<?php if (isset($_POST['email'])) {echo($_POST['email']);} ?>" class="form-control">
                      <?php
                        if (isset($_SESSION["emailError"])) {
                          if ($_SESSION["emailError"] === true) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          }
                        }
                      ?>
                    </div>
                    <div class="form-group">
                      <label>Password:</label>
                      <input type="password" name="password" required="" class="form-control">
                      <?php
                        if (isset($_SESSION["passwordError"])) {
                          if ($_SESSION["passwordError"] === true) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          }
                        }
                      ?>
                    </div>
                    <div class="py-3">
                      <button class="col-6 btn btn-dark" name="submit">
                        LOGIN
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