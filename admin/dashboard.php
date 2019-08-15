<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staffPin = $_SESSION['staff_pin'];
    $userId = $_SESSION['user_id'];
    $query = "SELECT `employee_leave`.*, `users`.`first_name`, `users`.`last_name` FROM `employee_leave` JOIN `users` WHERE `users`.`id`=`employee_leave`.`user_id`";
    $result = $conn->query($query);
    if (($result->num_rows > 0)){
      $index = 0;
      while ($row = $result->fetch_assoc()) {
        $leave_applications[] = array(
          'id' => $row['id'], 'purpose' => $row['purpose'], 'application_date' => $row['application_date'],
          'start_date' => $row['start_date'], 'stop_date' => $row['stop_date'],
          'extra_information' => $row['extra_information'], 'to_director' => $row['to_director'],
          'to_registrar' => $row['to_registrar'], 'approval_status' => $row['approval_status'],
          'approval_date' => $row['approval_date'], 'full_name' => $row['first_name'] . ' ' . $row['last_name']
        );
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Leave Applications</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="">
        Leave MS <span class="badge badge-info">Admin</span>
      </a>
      <ul class="navbar-nav offset-md-6 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="employees.php">Employees</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">Leave Applications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="departments.php">Departments</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <!-- Employee Leave section -->
      <div class="row py-4">
        <div class="col-10 mx-auto">
          <!-- Title -->
          <div class="row align-items-center pb-4">
            <div class="col-6">
              <h2>Employee Leave Applications</h2>
            </div>
          </div>

          <!-- Employee Leave list -->
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Employee</th>
                  <th>Application Date</th>
                  <th>Purpose</th>
                  <th>Period</th>
                  <th>Approval Date</th>
                  <th>Approval Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($leave_applications as $leave_application): ++$index; ?>
                  <tr>
                    <td><?php echo $index; ?></td>
                    <td><?php echo $leave_application["full_name"]; ?></td>
                    <td><?php echo date('d-M-Y', strtotime($leave_application['application_date'])); ?></td>
                    <td><?php echo $leave_application["purpose"]; ?></td>
                    <td>
                      <?php
                        $start = date_create($leave_application["start_date"]);
                        $stop = date_create($leave_application["stop_date"]);
                        echo date_diff($stop, $start)->format("%a Days");
                      ?>
                    </td>
                    <td>
                      <?php
                        switch ($leave_application["approval_date"]) {
                          case NULL:
                            echo '<span class="badge badge-warning">Pending</span>';
                            break;
                          default:
                            echo date('d-M-Y', strtotime($leave_application['approval_date']));
                            break;
                        }
                      ?>
                    </td>
                    <td>
                      <?php
                        switch ($leave_application["approval_status"]) {
                          case NULL:
                            echo '<span class="badge badge-warning">Pending</span>';
                            break;
                          case '0':
                            echo '<span class="badge badge-danger">Disapproved</span>';
                            break;
                          case '1':
                            echo '<span class="badge badge-success">Approved</span>';
                            break;
                        }
                      ?>
                    </td>
                    <td>
                      <a class="btn btn-outline-dark btn-sm" href="<?php echo 'employee-leave-detail.php?e=' . $leave_application['id'] ?>">VIEW</a>
                    </td>
                  </tr>
                <?php endforeach ?>
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
</html>