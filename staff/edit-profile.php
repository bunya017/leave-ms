<?php
  session_start();
  require("../config.php");
  /*
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staff = $_SESSION['staff_pin'];
    $query = "SELECT * FROM `users` JOIN `departments` WHERE `users`.`staff_pin`='$staff' AND `departments`.`id`=`users`.`department_id`";
    $result = $conn->query($query);
  }
  */
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
        <div class="col-8 mx-auto">
          <div class="row py-2">
            <div class="col-10 mx-auto">
              <div class="card shadow-lg border-0">
                <div class="card-header">
                  <h3>
                    Edit Profile Details
                  </h3>
                </div>
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label>Usernname:</label>
                      <input type="text" disabled="" value="username" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>First Name:</label>
                      <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Last Name:</label>
                      <input type="text" class="form-control">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer border-0">
                      <a class="btn btn-outline-secondary" href="profile.php">
                        CANCEL
                      </a>
                      <button class="btn btn-dark">
                        UPDATE PROFILE
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