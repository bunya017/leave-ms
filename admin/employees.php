<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  require("../auth/admin-permissions.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $query = "SELECT * FROM `users` JOIN `departments` WHERE `departments`.`id`=`users`.`department_id`";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
      $employeeList[] = array(
        'staff_pin' => $row['staff_pin'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name'],
        'name' => $row['name'], 'short_code' => $row['short_code'], 'created_at' => $row['created_at'],
        'is_active' => $row['is_active'],
      );
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
    <link rel="stylesheet" href="../static/css/fontawesome/fontawesome-v5.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php include('../includes/admin_nav.php'); ?>
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
              <a class="btn btn-dark float-right" href="add-employee.php">
                ADD EMPLOYEE
              </a>
            </div>
            <?php
              if (isset($_SESSION["employeeCreated"]) && ($_SESSION["employeeCreated"] === TRUE)) {
                echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert">&times;</button>Employee added successfully!</div></div>';
                $_SESSION["employeeCreated"] = NULL;
              } elseif (isset($_SESSION["employeeDeleted"]) && ($_SESSION["employeeDeleted"] === TRUE)) {
                echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert">&times;</button>Employee deleted successfully!</div></div>';
                $_SESSION["employeeDeleted"] = NULL;
              }
            ?>
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
                <?php
                  $index = 0;
                  foreach ($employeeList as $employee) {
                    ++$index;
                    echo '<tr>';
                    echo '<td>' . $index . '</td>';
                    echo '<td>' . $employee['staff_pin'] . '</td>';
                    echo '<td>' . $employee['first_name'] . ' ' . $employee['last_name'] . '</td>';
                    echo '<td><abbr title="' . $employee['name'] . '">' . $employee['short_code'] . '</abbr></td>';
                    echo '<td>' . date('d-M-Y', strtotime($employee['created_at'])) . '</td>';
                    if ($employee['is_active'] == 1) {
                      echo '<td><span class="badge badge-success">Active</span></td>';
                    } else {
                      echo '<td><span class="badge badge-danger">Inactive</span></td>';
                    }
                    echo '<td><a class="btn btn-outline-dark btn-sm" href="employee-profile.php?e=' . $employee['staff_pin'] . '">VIEW</a></td>';
                    echo '<td><a class="btn btn-outline-danger btn-sm" href="delete-employee.php?e=' . $employee['staff_pin'] . '">DELETE</a></td>';
                    echo '</tr>';
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