<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  require("../auth/admin-permissions.php");
  if (isset($_SESSION["isLoggedIn"]) && ($_SESSION["isLoggedIn"] === TRUE)) {
    if (isset($_POST["addLeave"])) {
      if ((empty($_POST["leaveType"]) === TRUE)) {
        $_SESSION["leaveTypeError"] = true;
      } elseif (isset($_POST["leaveType"]) === TRUE) {
        $leaveType = stripcslashes($_POST["leaveType"]);
        $description = stripcslashes($_POST["description"]);
        if (!empty($description)) {
          $query = "INSERT into `leave_types` (leave_type, description) VALUES ('$leaveType', '$description')";
        } else {
          $query = "INSERT into `leave_types` (leave_type, description) VALUES ('$leaveType', '$description')";
        }
        if ($conn->query($query) === TRUE) {
          $_SESSION["leaveCreated"] = true;
          $_POST = NULL;
          header("location: leave-types.php");
        } elseif (strpos($conn->error, "'leave_type'") > 0) {
          $_SESSION["leaveTypeDupError"] = true;
        }
      }
    }
  }
?>
<html>
  <head>
    <title>New Leave Type</title>
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
      <div class="row">
        <div class="col-8 mx-auto">
          <div class="row py-5">
            <div class="col-10 mx-auto">
              <div class="card shadow-lg border-0">
                <div class="card-header">
                  <h3>
                    Add New Leave Type
                  </h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form method="post">
                        <div class="form-group">
                          <label>Leave Type:</label>
                          <input type="text" name="leaveType" required="" value="<?php if (isset($_POST['leaveType'])) {echo($_POST['leaveType']);} ?>"class="form-control">
                          <?php
                            if (isset($_SESSION["leaveTypeError"])) {
                              // Catch empty field error
                              if ($_SESSION["leaveTypeError"] === true) {
                                echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                                $_SESSION["leaveTypeError"] = NULL;
                              }
                            } elseif (isset($_SESSION["leaveTypeDupError"]) and ($_SESSION["leaveTypeDupError"] === TRUE)) {
                              // Catch duplicate leave_type error
                              echo '<small class="text-danger"><strong>This leave type already exists!</strong></small>';
                                $_SESSION["leaveTypeDupError"] = NULL;
                            }
                          ?>
                        </div>
                        <div class="form-group">
                          <label>Description <small><i>(Optional)</i></small>:</label>
                          <textarea class="form-control" name="description"rows="3"><?php if(isset($_POST['description'])) {echo trim($_POST['description']);} ?></textarea>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <a class="btn btn-outline-secondary" href="leave-types.php">
                            CANCEL
                          </a>
                          <button class="btn btn-dark" name="addLeave">
                            ADD LEAVE TYPE
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