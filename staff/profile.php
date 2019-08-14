<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staff = $_SESSION['staff_pin'];
    $query = "SELECT * FROM `users` JOIN `departments` WHERE `users`.`staff_pin`='$staff' AND `departments`.`id`=`users`.`department_id`";
    $result = $conn->query($query);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Profile</title>
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
          <a class="nav-link" href="">My profile</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-10 mx-auto">
          <!-- Profile details card -->
          <div class="row py-5">
            <?php
              if (isset($_SESSION["staffProfileEdited"]) && ($_SESSION["staffProfileEdited"] === TRUE)) {
                echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert">&times;</button>Profile updated successfully!</div></div>';
                $_SESSION["staffProfileEdited"] = NULL;
              } elseif (isset($_SESSION["passwordChanged"]) && ($_SESSION["passwordChanged"] === TRUE)) {
                echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert">&times;</button>Password changed successfully!</div></div>';
                $_SESSION["passwordChanged"] = NULL;
              }
            ?>
            <div class="col-10 mx-auto">
              <?php if (($result->num_rows > 0)): $row = $result->fetch_assoc();?>
                <div class="card shadow-lg border-0 pb-3">
                  <div class="card-header">
                    <h2>
                      Profile Details
                      <div class="float-right">
                        <a class="btn btn-outline-dark mx-1" href="edit-profile.php">
                          EDIT PROFILE
                        </a>
                        <a class="btn btn-outline-dark mx-1" href="change-password.php">
                          CHANGE PASSWORD
                        </a>
                      </div>
                    </h2>
                  </div>
                  <div class="card-body">
                    <div class="row py-1">
                      <h4 class="col-6">Staff Pin</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['staff_pin'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Email</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['email'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Department</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['name'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">First Name</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['first_name'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Last Name</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['last_name'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Total Leave Days</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['total_leave_days'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Leave Days Remaining</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['leave_days_left'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Last Profile Update Date</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo date('d-M-Y', strtotime($row['updated_at'])) ?></span>
                      </h4>
                    </div>
                  </div>
                </div>
              <?php else: ?>
                <div class="col-12 mt-5 text-center">
                  <h1 class="text-dark display-1">404</h1>
                  <p class="lead pb-3">We can't seem to find the page you're looking for.</p>
                  <ul class="list-inline">
                    <a class="btn btn-outline-dark btn-sm mx-1" class="text-dark list-inline-item" href="dashboard.php">Back to Home</a>
                    <a class="btn btn-outline-dark btn-sm mx-1" class="text-dark list-inline-item" href="employees.php">Employees</a>
                  </ul>
                </div>
              <?php endif ?>
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
  <script>
    setTimeout(function () { // Hide alert after 5 seconds
        $(".alert").alert('close');
      }, 5000
    );
  </script>
</html>