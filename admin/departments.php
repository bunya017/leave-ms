<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $query = "SELECT * FROM `departments`";
    $result = $conn->query($query);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Departments</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php include('../includes/admin_nav.php'); ?>
    <div class="container">
      <!-- Employee section -->
      <div class="row py-4">
        <div class="col-10 mx-auto">
          <?php
            if (isset($_SESSION["deptCreated"])) {
              if ($_SESSION["deptCreated"] === true) {
                echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button class="close" data-dismiss="alert">&times;</button>Department added successfully!</div></div>';
                $_SESSION["deptCreated"] = NULL;
              }
            }
          ?>
          <!-- Title -->
          <div class="row align-items-center py-3">
            <div class="col-6">
              <h2>Departments</h2>
            </div>
            <div class="col-6">
              <a class="btn btn-dark float-right" href="add-department.php">
                ADD DEPARTMENT
              </a>
            </div>
          </div>

          <!-- Employee list -->
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Short Code</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Show Departments
                  if ($result->num_rows > 0) {
                    $index = 0;
                    while ($row = $result->fetch_assoc()) {
                      ++$index;
                      echo "<tr><td>" . $index . "</td><td>" . $row["name"] . "</td><td>" . $row["short_code"] . "</td></tr>";
                    }
                  }
                ?>
              </tbody>
            </table>
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