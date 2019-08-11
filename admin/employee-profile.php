<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staff = $_GET['e'];
    $query = "SELECT * FROM `users` JOIN `departments` WHERE users.staff_pin='$staff' AND departments.id=users.department_id";
    $result = $conn->query($query);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Employee Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
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
          <a class="nav-link" href="departments.php">Departments</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-10 mx-auto">
          <!-- Profile details card -->
          <div class="row py-5">
            <?php if (($result->num_rows > 0)): $row = $result->fetch_assoc();?>
              <div class="col-10 mx-auto">
                <div class="card shadow-lg border-0 pb-3">
                  <div class="card-header">
                    <h2>
                      <?php echo $row['first_name'] . ' ' . $row['last_name'] ?> Profile
                      <div class="float-right">
                        <button class="btn btn-outline-dark mx-1" data-toggle="modal" data-target="#EditEmployeeModal">
                          EDIT EMPLOYEE PROFILE
                        </button>
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
                      <h4 class="col-6">Department</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['name'] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Added on</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo date('d-M-Y', strtotime($row['created_at'])) ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Staff Status</h4>
                      <h4 class="col-6">
                        <?php if ($row['is_active'] == 1): ?>
                          <span class="badge badge-success font-weight-light">
                            Active
                          </span>
                        <?php else: ?>
                          <span class="badge badge-danger font-weight-light">
                            Inactive
                          </span>
                        <?php endif ?>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Leave Days Left</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row['leave_days_left'] . ' of ' . $row['total_leave_days'] ?></span>
                      </h4>
                    </div>
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

          <!-- Edit Employee profile -->
          <div class="modal" id="EditEmployeeModal" data-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Edit Employee Profile</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form>
                        <div class="form-group">
                          <label>Staff Pin:</label>
                          <input type="text" class="form-control">
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
                        <div class="form-group">
                          <label>Department:</label>
                          <input type="text" class="form-control">
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            CANCEL
                          </button>
                          <button type="button" class="btn btn-dark" data-dismiss="modal">
                            EDIT EMPLOYEE PROFILE
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