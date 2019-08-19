<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  require("../auth/admin-permissions.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    if (isset($_POST["addDepartment"])) {
      if ((empty($_POST["name"]) === TRUE) and (empty($_POST["shortCode"]) === TRUE)) {
        $_SESSION["deptNameError"] = true;
        $_SESSION["shortCodeError"] = true;
      } elseif (empty($_POST["shortCode"]) === TRUE) {
        $_SESSION["shortCodeError"] = true;
      } elseif (empty($_POST["name"]) === TRUE) {
        $_SESSION["deptNameError"] = true;
      } elseif (isset($_POST["name"]) === TRUE and isset($_POST["shortCode"]) === TRUE) {
        $name = stripcslashes($_POST["name"]);
        $shortCode = stripcslashes($_POST["shortCode"]);
        $query = "INSERT into `departments` (name, short_code) VALUES ('$name', '$shortCode')";
        if ($conn->query($query) === TRUE) {
          $_SESSION["deptCreated"] = true;
          $_POST = NULL;
          header("location: departments.php");
        } elseif (strpos($conn->error, "'name'") > 0) {
          $_SESSION["deptNameDupError"] = true;
        } elseif (strpos($conn->error, "'short_code'") > 0) {
          $_SESSION["shortCodeDupError"] = true;
        }
      }
    }
  }
?>
<html>
  <head>
    <title>New Department</title>
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
                    Add New Deparment
                  </h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form method="post">
                        <div class="form-group">
                          <label>Name:</label>
                          <input type="text" name="name" value="<?php if (isset($_POST['name'])) {echo($_POST['name']);} ?>"class="form-control">
                          <?php
                            if (isset($_SESSION["deptNameError"])) {
                              // Catch empty field error
                              if ($_SESSION["deptNameError"] === true) {
                                echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                                $_SESSION["deptNameError"] = NULL;
                              }
                            } elseif (isset($_SESSION["deptNameDupError"]) and ($_SESSION["deptNameDupError"] === TRUE)) {
                              // Catch duplicate name error
                              echo '<small class="text-danger"><strong>This department already exists!</strong></small>';
                                $_SESSION["deptNameDupError"] = NULL;
                            }
                          ?>
                        </div>
                        <div class="form-group">
                          <label>Short Code:</label>
                          <input type="text" name="shortCode" value="<?php if (isset($_POST['shortCode'])) {echo($_POST['shortCode']);} ?>" class="form-control">
                          <?php
                            if (isset($_SESSION["shortCodeError"])) {
                              // Catch empty field error
                              if ($_SESSION["shortCodeError"] === true) {
                                echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                                $_SESSION["shortCodeError"] = NULL;
                              }
                            } elseif (isset($_SESSION["shortCodeDupError"]) and ($_SESSION["shortCodeDupError"] === TRUE)) {
                              // Catch duplicate short_code error
                              echo '<small class="text-danger"><strong>This name short code is already in use!</strong></small>';
                                $_SESSION["shortCodeDupError"] = NULL;
                            }
                          ?>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <a class="btn btn-outline-secondary" href="departments.php">
                            CANCEL
                          </a>
                          <button class="btn btn-dark" name="addDepartment">
                            ADD DEPARTMENT
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