<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $query = "SELECT * FROM `departments`";
    $result = $conn->query($query);
  }
  if (isset($_POST["addEmployee"])) {
    if (empty($_POST["staff_pin"])) {
      $_SESSION["staffError"] = true;
    }
    if (empty($_POST["email"])) {
      $_SESSION["emailError"] = true;
    }
    if (empty($_POST["department"]["value"])) {
      $_SESSION["deptError"] = true;
    }
    if (empty($_POST["first_name"])) {
      $_SESSION["firstNameError"] = true;
    }
    if (empty($_POST["last_name"])) {
      $_SESSION["lastNameError"] = true;
    }
  }
  if (isset($_POST["addEmployee"], $_POST["staff_pin"], $_POST["department"], $_POST["email"], $_POST["first_name"], $_POST["last_name"])) {
    $staff_pin = stripcslashes($_POST["staff_pin"]);
    $department = stripcslashes($_POST["department"]);
    $email = stripcslashes($_POST["email"]);
    $first_name = stripcslashes($_POST["first_name"]);
    $last_name = stripcslashes($_POST["last_name"]);
    $staff_role = 1;
    $password = password_hash("password1234", PASSWORD_DEFAULT);
    $query = "INSERT into `users` (staff_pin, email, password, department_id, first_name, last_name, role_id) VALUES ('$staff_pin', '$email', '$password', '$department', '$first_name', '$last_name', '$staff_role')";
    if ($conn->query($query) === TRUE) {
      echo "<br>Created user<br>";
    } else {
      echo "<br>" . $conn->error;
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Employees</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="employee-leave.html">
        Leave MS <span class="badge badge-info">Admin</span>
      </a>
      <ul class="navbar-nav offset-md-6 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="">Employees</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Leave Applications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="departments.php">Departments</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <!-- Employee section -->
      <div class="row py-5">
        <div class="col-10 mx-auto">
          <!-- Title -->
          <div class="row align-items-center pb-4">
            <div class="col-6">
              <h2>Employees</h2>
            </div>
            <div class="col-6">
              <button type="button" class="btn btn-dark float-right" data-toggle="modal" data-target="#AddEmployeeModal">
                ADD EMPLOYEE
              </button>
            </div>
          </div>

          <!-- Employee list -->
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Staff Pin</th>
                  <th>Full Name</th>
                  <th>Department</th>
                  <th>Added on</th>
                  <th>Status</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>COSC0001</td>
                  <td>Jane Mikel</td>
                  <td>
                    <abbr title="Computer Science">COSC</abbr>
                  </td>
                  <td>25-Jan-2016</td>
                  <td><span class="badge badge-success">Active</span></td>
                  <td>
                    <a class="btn btn-outline-dark btn-sm" href="employee-profile.html">VIEW</a>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>COEN0001</td>
                  <td>John Mikel</td>
                  <td>
                    <abbr title="Computer Engineering">COEN</abbr>
                  </td>
                  <td>14-Jul-2016</td>
                  <td><span class="badge badge-danger">Inactive</span></td>
                  <td>
                    <a class="btn btn-outline-dark btn-sm" href="employee-profile.html">VIEW</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Add Employee Modal -->
          <div class="modal" id="AddEmployeeModal" data-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Add New Employee</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form method="post">
                        <div class="form-group">
                          <label>Staff Pin:</label>
                          <input type="text" required="" name="staff_pin" class="form-control">
                          <?php
                            // Catch empty field error
                            if (isset($_SESSION["staffError"]) && ($_SESSION["staffError"] === true)) {
                              echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                              $_SESSION["staffError"] = NULL;
                            }
                          ?>
                        </div>
                        <div class="form-group">
                          <label>Department:</label>
                          <select class="form-control" required="" name="department">
                            <option value="">-- Choose Department --</option>
                            <?php
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                  echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                }
                              }
                            ?>
                          </select>
                          <?php
                            // Catch empty field error
                            if (isset($_SESSION["deptError"]) && ($_SESSION["deptError"] === true)) {
                              echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                              $_SESSION["deptError"] = NULL;
                            }
                          ?>
                        </div>
                        <div class="form-group">
                          <label>Email:</label>
                          <input type="email" required="" name="email" class="form-control">
                          <?php
                            // Catch empty field error
                            if (isset($_SESSION["emailError"]) && ($_SESSION["emailError"] === true)) {
                              echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                              $_SESSION["emailError"] = NULL;
                            }
                          ?>
                        </div>
                        <div class="form-group">
                          <label>First Name:</label>
                          <input type="text" required="" name="first_name" class="form-control">
                          <?php
                            // Catch empty field error
                            if (isset($_SESSION["firstNameError"]) && ($_SESSION["firstNameError"] === true)) {
                              echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                              $_SESSION["firstNameError"] = NULL;
                            }
                          ?>
                        </div>
                        <div class="form-group">
                          <label>Last Name:</label>
                          <input type="text" required="" name="last_name" class="form-control">
                          <?php
                            // Catch empty field error
                            if (isset($_SESSION["lastNameError"]) && ($_SESSION["lastNameError"] === true)) {
                              echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                              $_SESSION["lastNameError"] = NULL;
                            }
                          ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            CANCEL
                          </button>
                          <button type="submit" name="addEmployee" class="btn btn-dark">
                            ADD EMPLOYEE
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
</html>