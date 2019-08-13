<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    if (isset($_POST["applyLeave"])) {
      if (empty($_POST["purpose"])) {
        $_SESSION["purposeError"] = true;
      }
      if (empty($_POST["start_date"])) {
        $_SESSION["startDateError"] = true;
      }
      if (empty($_POST["stop_date"])) {
        $_SESSION["stopDateError"] = true;
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
                    <form method="post">
                      <div class="form-group">
                        <label>Purpose:</label>
                        <input type="text" name="purpose" class="form-control">
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
                        <input type="date" name="start_date" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["startDateError"]) && ($_SESSION["startDateError"] === TRUE)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["startDateError"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>End Date:</label>
                        <input type="date" name="stop_date" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["stopDateError"]) && ($_SESSION["stopDateError"] === TRUE)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["stopDateError"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>Extra Information:</label>
                        <textarea class="form-control" name="extra_information" rows="3"></textarea>
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