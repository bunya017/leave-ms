<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $leaveId = $_GET['e'];
    $query = "SELECT * FROM `employee_leave` WHERE id='$leaveId'";
    $result = $conn->query($query);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Leave Detail</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php include('../includes/staff_nav.php'); ?>
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-10 mx-auto">
          <div class="row py-5">
            <div class="col-12 col-lg-10 mx-auto">
              <?php if (($result->num_rows > 0)): $row = $result->fetch_assoc();?>
                <div class="card shadow-lg border-0 pb-3">
                  <div class="card-header">
                    <h3>
                      <?php echo $row["purpose"]?>
                    </h3>
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
                      <h4 class="col-6">Purpose</h4>
                      <h4 class="col-6">
                        <span class="font-weight-light"><?php echo $row["purpose"]?></span>
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
                    <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="profile.php">
                      Profile
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