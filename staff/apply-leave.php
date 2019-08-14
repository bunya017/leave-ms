<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staff_pin = $_SESSION["staff_pin"];
    $query = "SELECT * FROM `users` WHERE staff_pin='$staff_pin'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $staffLeaveDays = $row["total_leave_days"];
      $staffLeaveDaysLeft = $row["leave_days_left"];
    }
    if (isset($_POST["applyLeave"])) {
      if (empty($_POST["purpose"])) {
        $_SESSION["purposeError"] = true;
      }
      if (empty($_POST["start_date"])) {
        $_SESSION["startDateError"] = true;
      }
      if (empty($_POST["stop_date"])) {
        $_SESSION["stopDateError"] = true;
      } else {
        $start = date_create($_POST["start_date"]);
        $stop = date_create($_POST["stop_date"]);
        $now = date_create("now");
        if ($start > $stop) {
          $_SESSION["negativeDateError"] = true;
        } elseif ($now > $start) {
          $_SESSION["startLessThanToday"] = true;
        } elseif ($now > $stop) {
          $_SESSION["stopLessThanToday"] = true;
        }
      }
    }
    if (isset($_POST["applyLeave"], $_POST["purpose"], $_POST["start_date"],$_POST["stop_date"])) {
      $user_id = $_SESSION["user_id"];
      $purpose = stripcslashes($_POST['purpose']);
      $start_date = stripcslashes($_POST['start_date']); // To be used for SQL query
      $stop_date = stripcslashes($_POST['stop_date']); // To be used for SQL query
      $start = date_create($start_date);
      $stop = date_create($stop_date);
      $now = date_create("now");
      $interval = date_diff($stop, $start)->format("%a");
      if (($interval > $staffLeaveDaysLeft) && ($staffLeaveDaysLeft == $staffLeaveDays)) {
        $_SESSION["aboveLeaveDaysError"] = true;
      } elseif (($interval > $staffLeaveDaysLeft) && ($staffLeaveDaysLeft < $staffLeaveDays)) {
        $_SESSION["aboveLeaveDaysLeftError"] = true;
      } elseif ($start > $stop) {
          $_SESSION["negativeDateError"] = true;
      } elseif ($now > $start) {
        $_SESSION["startLessThanToday"] = true;
      } elseif ($now > $stop) {
        $_SESSION["stopLessThanToday"] = true;
      } else {
        if (isset($_POST["extra_information"]) && (!empty($_POST["extra_information"]))) {
          $extra_information = htmlspecialchars($_POST['extra_information'], ENT_QUOTES);
          $leaveQuery = "INSERT into `employee_leave` (purpose, start_date, stop_date, extra_information, user_id) VALUES ('$purpose', '$start_date', '$stop_date', '$extra_information', '$user_id')";
        } else {
          $leaveQuery = "INSERT into `employee_leave` (purpose, start_date, stop_date, user_id) VALUES ('$purpose', '$start_date', '$stop_date', '$user_id')";
        }
        if ($conn->query($leaveQuery) === TRUE) {
          $_SESSION["leaveApplied"] = true;
          $_POST = NULL;
          header("location: dashboard.php");
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>New Leave Application</title>
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
          <a class="nav-link" href="profile.php">My profile</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 mx-auto">
          <div class="row py-2">
            <div class="col-sm-12 col-md-10 mx-auto">
               <div class="card shadow-lg border-0">
                  <div class="card-header">
                    <h3>
                      New Leave Application
                    </h3>
                  </div>
                  <div class="card-body">
                  <?php
                    if (isset($_SESSION["aboveLeaveDaysError"]) && ($_SESSION["aboveLeaveDaysError"] === TRUE)) {
                      echo '<div class="alert alert-danger alert-dismissible text-center my-3"><button type="button" class="close" data-dismiss="alert">&times;</button>Leave period cannot be longer than ' . $staffLeaveDays . ' days!</div>';
                      $_SESSION["aboveLeaveDaysError"] = NULL;
                    } else if (isset($_SESSION["aboveLeaveDaysLeftError"]) && ($_SESSION["aboveLeaveDaysLeftError"] === TRUE)) {
                      echo '<div class="alert alert-danger alert-dismissible text-center my-3"><button type="button" class="close" data-dismiss="alert">&times;</button>Leave period cannot be longer than ' . $staffLeaveDaysLeft . ' days!</div>';
                      $_SESSION["aboveLeaveDaysLeftError"] = NULL;
                    }
                  ?>
                    <form method="post">
                      <div class="form-group">
                        <label>Purpose:</label>
                        <input type="text" name="purpose" value="<?php if(isset($_POST['purpose'])){echo($_POST['purpose']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["purposeError"]) && ($_SESSION["purposeError"] === TRUE)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["purposeError"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>Start Date:</label>
                        <input type="date" required="" name="start_date" value="<?php if(isset($_POST['start_date'])){echo($_POST['start_date']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["startDateError"]) && ($_SESSION["startDateError"] === TRUE)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["startDateError"] = NULL;
                          } elseif (isset($_SESSION["negativeDateError"]) && ($_SESSION["negativeDateError"] === TRUE)) {
                            echo '<small class="text-danger"><strong>Start date cannot be greater than end date!</strong></small>';
                            $_SESSION["negativeDateError"] = NULL;
                          } elseif (isset($_SESSION["startLessThanToday"]) && ($_SESSION["startLessThanToday"] === TRUE)) {
                            echo '<small class="text-danger"><strong>Start date cannot be less than today!</strong></small>';
                            $_SESSION["startLessThanToday"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>End Date:</label>
                        <input type="date" required="" name="stop_date" value="<?php if(isset($_POST['stop_date'])){echo($_POST['stop_date']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["stopDateError"]) && ($_SESSION["stopDateError"] === TRUE)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["stopDateError"] = NULL;
                          } elseif (isset($_SESSION["stopLessThanToday"]) && ($_SESSION["stopLessThanToday"] === TRUE)) {
                            echo '<small class="text-danger"><strong>End date cannot be less than today!</strong></small>';
                            $_SESSION["stopLessThanToday"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>Extra Information <small><i>(Optional)</i></small>:</label>
                        <textarea class="form-control" name="extra_information"rows="3"><?php if(isset($_POST['extra_information'])) {echo trim($_POST['extra_information']);} ?></textarea>
                      </div>
                      <!-- Modal footer -->
                      <div class="modal-footer border-0">
                        <a class="btn btn-outline-secondary" href="dashboard.php">
                          CANCEL
                        </a>
                        <button class="btn btn-dark" name="applyLeave">
                          APPLY FOR LEAVE
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
  </body>
  <style>
    body {
      background-color: #f4f3f4 !important;
    }
  </style>
</html>