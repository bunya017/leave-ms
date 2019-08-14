<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staffPin = $_SESSION['staff_pin'];
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM `users` JOIN `employee_leave` WHERE `users`.`staff_pin`='$staffPin' AND `employee_leave`.`user_id`='$userId'";
    $result = $conn->query($query);
    if (($result->num_rows > 0)){
      $staffRow = $result->fetch_assoc();
      $staff = array('staff_pin' => $staffRow['staff_pin'], 'email' => $staffRow['email'],
        'first_name' => $staffRow['first_name'], 'last_name' => $staffRow['last_name'],
        'department_id' => $staffRow['department_id'], 'total_leave_days' => $staffRow['total_leave_days'],
        'leave_days_left' => $staffRow['leave_days_left']
      );
      $leave_applications[] = array(
        'id' => $staffRow['id'], 'purpose' => $staffRow['purpose'], 'application_date' => $staffRow['application_date'],
        'start_date' => $staffRow['start_date'], 'stop_date' => $staffRow['stop_date'],
        'extra_information' => $staffRow['extra_information'], 'to_director' => $staffRow['to_director'],
        'to_registrar' => $staffRow['to_registrar'], 'approval_status' => $staffRow['approval_status'],
        'approval_date' => $staffRow['approval_date']
      );
      while ($row = $result->fetch_assoc()) {
        $leave_applications[] = array(
          'id' => $row['id'], 'purpose' => $row['purpose'], 'application_date' => $row['application_date'],
          'start_date' => $row['start_date'], 'stop_date' => $row['stop_date'],
          'extra_information' => $row['extra_information'], 'to_director' => $row['to_director'],
          'to_registrar' => $row['to_registrar'], 'approval_status' => $row['approval_status'],
          'approval_date' => $row['approval_date']
        );
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <link rel="stylesheet" href="../static/css/fontawesome/fontawesome-v5.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="">Leave MS</a>
      <ul class="navbar-nav offset-md-8 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="profile.php">My profile</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <!-- Dashboard Cards -->
      <div class="row">
        <div class="col-10 mx-auto">
          <div class="row align-items-center py-3">
            <h1>Dashboard</h1>
          </div>
          <div class="row align-items-center py-3">
            <div class="col-12 col-sm-6 col-lg-3 py-2 py-lg-0">
              <div class="card shadow-lg" style="min-height: 100px;">
                <div class="text-center py-3">
                  <h2>16 <i class="fa fa-door-open"></i></h2>
                  <h6>Leave Days Left of 30</h6>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 py-2 py-lg-0">
              <div class="card shadow-lg" style="min-height: 100px;">
                <div class="text-center py-3">
                  <h2 class="text-success">1 <i class="fa fa-door-open"></i></h2>
                  <h6>Leave Approved</h6>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 py-2 py-lg-0">
              <div class="card shadow-lg" style="min-height: 100px;">
                <div class="text-center py-3">
                  <h2 class="text-warning">1 <i class="fa fa-door-open"></i></h2>
                  <h6>Leave Pending Approval</h6>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 py-2 py-lg-0">
              <div class="card shadow-lg" style="min-height: 100px;">
                <div class="text-center py-3">
                  <h2 class="text-danger">1 <i class="fa fa-door-open"></i></h2>
                  <h6>Disapproved Leave</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- leave section -->
      <div class="row py-5">
        <div class="col-10 mx-auto">
          <?php
            if (isset($_SESSION["leaveApplied"]) && ($_SESSION["leaveApplied"] === TRUE)) {
              echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert">&times;</button>Leave applied successfully!</div></div>';
              $_SESSION["leaveApplied"] = NULL;
            }
          ?>
          <!-- Title -->
          <div class="row align-items-center py-3">
            <div class="col-6">
              <h2>Leave Applications</h2>
            </div>
            <div class="col-6">
              <a class="btn btn-dark float-right" href="apply-leave.php">
                APPLY FOR LEAVE
              </a>
            </div>
          </div>

          <!-- Leave list -->
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Applictaion Date</th>
                  <th>Purpose</th>
                  <th>Period</th>
                  <th>Approval Date</th>
                  <th>Approval Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>02-Aug-2019</td>
                  <td>Weekend</td>
                  <td>2 Days</td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td>
                    <button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#viewLeaveDetail">VIEW
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>22-Jan-2019</td>
                  <td>Maternity</td>
                  <td>14 Days</td>
                  <td>25-Jan-2019</td>
                  <td><span class="badge badge-success">Approved</span></td>
                  <td><button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#viewLeaveDetail">VIEW</button>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>12-Jul-2018</td>
                  <td>Chilling</td>
                  <td>12 Days</td>
                  <td>14-Jul-2018</td>
                  <td><span class="badge badge-danger">Disapproved</span></td>
                  <td><button class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#viewLeaveDetail">VIEW</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- View Leave Modal -->
          <div class="modal" id="viewLeaveDetail" data-backdrop="static" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Chilling</h4>
                  <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row py-3">
                    <h4 class="col-6">Application Date</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">12-Jul-2018</span>
                    </h4>
                    <h4 class="col-6">Purpose</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">Chilling</span>
                    </h4>
                    <h4 class="col-6">Period</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">12 Days</span>
                    </h4>
                    <h4 class="col-6">Leave Starts</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">17-Jul-2018</span>
                    </h4>
                    <h4 class="col-6">Leave Ends</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">29-Jul-2018</span>
                    </h4>
                    <h4 class="col-6">Forwarded to Director</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">Yes</span>
                    </h4>
                    <h4 class="col-6">Forwarded to Registrar</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">Yes</span>
                    </h4>
                    <h4 class="col-6">Approval Status</h4>
                    <h4 class="col-6">
                      <span class="badge badge-danger font-weight-light">
                        Disapproved
                      </span>
                    </h4>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
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