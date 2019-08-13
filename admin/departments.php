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
    <?php
      session_start();
      require("../config.php");
      if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
        $query = "SELECT * FROM `departments`";
        $result = $conn->query($query);
      }
      if (isset($_POST["addDepartment"])) {
        if ((empty($_POST["name"]) === TRUE) and (empty($_POST["shortCode"]) === TRUE)) {
          $_SESSION["deptNameError"] = true;
          $_SESSION["shortCodeError"] = true;
        } elseif (empty($_POST["shortCode"]) === TRUE) {
          $_SESSION["shortCodeError"] = true;
        } elseif (empty($_POST["name"]) === TRUE) {
          $_SESSION["deptNameError"] = true;
        } elseif (isset($_POST["name"]) === TRUE and isset($_POST["shortCode"]) === TRUE) {
          $name = stripcslashes($_POST["name"]);
          $shortCode = stripcslashes($_POST["shortCode"]);
          $query = "INSERT into `departments` (name, short_code) VALUES ('$name', '$shortCode')";
          if ($conn->query($query) === TRUE) {
            $_SESSION["deptCreated"] = true;
            $_POST = NULL;
          } elseif (strpos($conn->error, "'name'") > 0) {
            $_SESSION["deptNameDupError"] = true;
          } elseif (strpos($conn->error, "'short_code'") > 0) {
            $_SESSION["shortCodeDupError"] = true;
          }
        }
      }
    ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="dashboard.php">
        Leave MS <span class="badge badge-info">Admin</span>
      </a>
      <ul class="navbar-nav offset-md-6 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="employees.php">Employees</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Leave Applications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">Departments</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <!-- Employee section -->
      <div class="row py-4">
        <div class="col-10 mx-auto">
          <?php
            if (isset($_SESSION["deptCreated"])) {
              if ($_SESSION["deptCreated"] === true) {
                echo '<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert">&times;</button>Department added successfully!</div>';
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
              <button type="button" class="btn btn-dark float-right" data-toggle="modal" data-target="#addDepartmentModal">
                ADD DEPARTMENT
              </button>
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

          <!-- Add Employee Modal -->
          <div class="modal" id="addDepartmentModal" data-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Add New Department</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form method="post">
                        <div class="form-group">
                          <label>Name:</label>
                          <input type="text" name="name" value="<?php if (isset($_POST['name'])) {echo($_POST['name']);} ?>"class="form-control">
                          <?php
                            if (isset($_SESSION["deptNameError"])) {
                              // Catch empty field error
                              if ($_SESSION["deptNameError"] === true) {
                                echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                                $_SESSION["deptNameError"] = NULL;
                              }
                            } elseif (isset($_SESSION["deptNameDupError"]) and ($_SESSION["deptNameDupError"] === TRUE)) {
                              // Catch duplicate name error
                              echo '<small class="text-danger"><strong>This name already exists!</strong></small>';
                                $_SESSION["deptNameDupError"] = NULL;
                            }
                          ?>
                        </div>
                        <div class="form-group">
                          <label>Short Code:</label>
                          <input type="text" name="shortCode" value="<?php if (isset($_POST['shortCode'])) {echo($_POST['shortCode']);} ?>" class="form-control">
                          <?php
                            if (isset($_SESSION["shortCodeError"])) {
                              // Catch empty field error
                              if ($_SESSION["shortCodeError"] === true) {
                                echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                                $_SESSION["shortCodeError"] = NULL;
                              }
                            } elseif (isset($_SESSION["shortCodeDupError"]) and ($_SESSION["shortCodeDupError"] === TRUE)) {
                              // Catch duplicate short_code error
                              echo '<small class="text-danger"><strong>This name short code exists!</strong></small>';
                                $_SESSION["shortCodeDupError"] = NULL;
                            }
                          ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            CANCEL
                          </button>
                          <button class="btn btn-dark" name="addDepartment">
                            ADD DEPARTMENT
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