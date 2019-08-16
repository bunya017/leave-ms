<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $leaveId = $_GET['e'];
    $query = "SELECT `employee_leave`.*, `users`.`first_name`, `users`.`last_name`, `users`.`staff_pin`,
    `users`.`leave_days_left`, `departments`.`name` FROM `employee_leave` JOIN`users` JOIN 
    `departments` WHERE `employee_leave`.`id`='$leaveId' AND  `users`.`id`=`employee_leave`.`user_id`
    AND  `departments`.`id`=`users`.`department_id`";
    $result = $conn->query($query);
    if (($result->num_rows > 0)){
      $row = $result->fetch_assoc();
    }
    if (isset($_POST["toDirector"])) {
      $toDirectorQuery = "UPDATE `employee_leave` SET to_director='1' WHERE `employee_leave`.`id`='$leaveId'";
      if ($conn->query($toDirectorQuery) === TRUE) {
        $_POST = NULL;
        header("location: employee-leave-detail.php?e=" . $leaveId);
      }
    } elseif (isset($_POST["toRegistrar"])) {
      $toRegistrarQuery = "UPDATE `employee_leave` SET to_registrar='1' WHERE `employee_leave`.`id`='$leaveId'";
      if ($conn->query($toRegistrarQuery) === TRUE) {
        $_POST = NULL;
        header("location: employee-leave-detail.php?e=" . $leaveId);
      }
    } elseif (isset($_POST["registrarApprove"])) {
      $now = date_format(date_create("now"), "Y-m-d");
      $start = date_create($row["start_date"]);
      $stop = date_create($row["stop_date"]);
      $leavePeriod = date_diff($stop, $start)->format("%a");
      $newLeaveDaysLeft = $row["leave_days_left"] - $leavePeriod;
      $staffPin = $row["staff_pin"];
      $conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
      $registrarApproveQuery = "UPDATE `employee_leave` SET approval_status='1', approval_date='$now' WHERE `employee_leave`.`id`='$leaveId'";
      $changeLeaveDaysQuery = "UPDATE `users` SET leave_days_left='$newLeaveDaysLeft' WHERE
        `users`.`staff_pin`='$staffPin'";
      $conn->query($registrarApproveQuery);
      $conn->query($changeLeaveDaysQuery);
      $conn->commit();
      $_POST = NULL;
      header("location: employee-leave-detail.php?e=" . $leaveId);
    } elseif (isset($_POST["registrarDisapprove"])) {
      $now = date_format(date_create("now"), "Y-m-d");
      $registrarDisapproveQuery = "UPDATE `employee_leave` SET approval_status='0', approval_date='$now' WHERE `employee_leave`.`id`='$leaveId'";
      if ($conn->query($registrarDisapproveQuery) === TRUE) {
        $_POST = NULL;
        header("location: employee-leave-detail.php?e=" . $leaveId);
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Leave Application Detail</title>
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
          <!-- View Employee Leave Detail -->
          <div class="row pt-4 pb-5">
            <div class="col-10 mx-auto">
              <?php if (!empty($row)): ?>
                <div class="card shadow-lg border-0">
                  <div class="card-header">
                    <form method="post">
                      <h3>
                        <?php echo $row["purpose"] . " - " . $row["first_name"] . " " . $row["last_name"]?>
                        <?php if ($row["approval_status"] === NULL): ?>
                          <?php if (($_SESSION["can_forward_to_director"] == 1) && ($row["to_director"] == 0)): ?>
                            <div class="float-right">
                              <button name="toDirector" class="btn btn-outline-dark btn-sm ml-2 py-0">
                                FORWARD TO DIRECTOR
                              </button>
                            </div>
                          <?php elseif (($_SESSION["can_forward_to_registrar"] == 1) && ($row["to_registrar"] == 0)  && ($row["to_director"] == 1)): ?>
                            <div class="float-right">
                              <button name="toRegistrar" class="btn btn-outline-dark btn-sm ml-2 py-0">
                                FORWARD TO REGISTRAR
                              </button>
                            </div>
                          <?php elseif (($_SESSION["role"] === "registrar") && ($row["to_director"] == 1)  && ($row["to_registrar"] == 1)): ?>
                            <div class="float-right">
                            <button  name="registrarApprove" class="btn btn-outline-success btn-sm ml-2 py-0">
                              APPROVE
                            </button>
                            <button  name="registrarDisapprove" class="btn btn-outline-danger btn-sm ml-2 py-0">
                              DISAPPROVE
                            </button>
                          </div>
                          <?php endif ?>
                        <?php endif ?>
                      </h3>
                    </form>
                  </div>
                  <div class="card-body">
                    <div class="row py-1">
                      <h4 class="col-6">Application Date</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light">
                          <?php echo date('d-M-Y', strtotime($row['application_date'])); ?>
                        </span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Employee</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row["first_name"] . " " . $row["last_name"]?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Purpose</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row["purpose"]?></span>
                      </h4>
                    </div>
                    <?php if (!empty($row["extra_information"])): ?>
                      <div class="row py-1">
                        <h4 class="col-6">Extra Information</h4>
                        <h4 class="col-6">
                          <span class="font-weight-light"><?php echo $row["extra_information"] ?></span>
                        </h4>
                      </div>
                    <?php endif ?>
                    <div class="row py-1">
                      <h4 class="col-6">Department</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row["name"] ?></span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Period</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light">
                          <?php
                            $start = date_create($row["start_date"]);
                            $stop = date_create($row["stop_date"]);
                            echo date_diff($stop, $start)->format("%a Days");
                          ?>
                        </span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Leave Starts</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light">
                          <?php echo date('d-M-Y', strtotime($row['start_date'])); ?>
                        </span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Leave Ends</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light">
                          <?php echo date('d-M-Y', strtotime($row['stop_date'])); ?>
                        </span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Forwarded to Director</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light">
                          <?php
                            switch ($row["to_director"]) {
                              case NULL:
                              case '0':
                                echo 'No';
                                break;
                              case '1':
                                echo 'Yes';
                                break;
                            }
                          ?>
                        </span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Forwarded to Registrar</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light">
                          <?php
                            switch ($row["to_registrar"]) {
                              case NULL:
                              case '0':
                                echo 'No';
                                break;
                              case '1':
                                echo 'Yes';
                                break;
                            }
                          ?>
                        </span>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Approval Status</h4>
                      <h4 class="col-6">
                        <?php
                          switch ($row["approval_status"]) {
                            case NULL:
                              echo '<span class="badge badge-warning font-weight-light">Pending</span>';
                              break;
                            case '0':
                              echo '<span class="badge badge-danger font-weight-light">Disapproved</span>';
                              break;
                            case '1':
                              echo '<span class="badge badge-success font-weight-light">Approved</span>';
                              break;
                          }
                        ?>
                      </h4>
                    </div>
                    <div class="row py-1">
                      <h4 class="col-6">Approval Date</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light">
                          <?php
                            switch ($row["approval_date"]) {
                              case NULL:
                                echo '<span class="badge badge-warning font-weight-light">Pending</span>';
                                break;
                              default:
                                echo date('d-M-Y', strtotime($row['approval_date']));
                                break;
                            }
                          ?>
                        </span>
                      </h4>
                    </div>
                  </div>
                </div>
              <?php else: ?>
                <div class="col-12 mt-5 text-center">
                  <h1 class="text-dark display-1">404</h1>
                  <p class="lead pb-3">We can't seem to find the page you're looking for.</p>
                  <ul class="list-inline">
                    <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="dashboard.php">
                      Dashboard
                    </a>
                    <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="employees.php">
                      Employees
                    </a>
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
</html>