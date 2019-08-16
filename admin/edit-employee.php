<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staffPin = $_GET['e'];
    $query = "SELECT * FROM `users` JOIN `departments` WHERE `users`.`staff_pin`='$staffPin'";
    $result = $conn->query($query);
    echo $conn->error;
    if (($result->num_rows > 0)){
      $staffRow = $result->fetch_assoc();
      $staff = array('staff_pin' => $staffRow['staff_pin'], 'email' => $staffRow['email'], 'first_name' => $staffRow['first_name'],
        'last_name' => $staffRow['last_name'], 'department_id' => $staffRow['department_id']
      );
      $departments[] = array('id' => $staffRow['id'], 'name' => $staffRow['name']);
      while ($row = $result->fetch_assoc()) {
        $departments[] = array('id' => $row['id'], 'name' => $row['name']);
      }
    }
    if (isset($_POST['editEmployee'])) {
      if (empty($_POST["staff_pin"])) {
        $_SESSION["staffUpdateError"] = true;
      }
      if (empty($_POST["email"])) {
        $_SESSION["emailUpdateError"] = true;
      }
      if (empty($_POST["department"])) {
        $_SESSION["deptUpdateError"] = true;
      }
      if (empty($_POST["first_name"])) {
        $_SESSION["firstNameUpdateError"] = true;
      }
      if (empty($_POST["last_name"])) {
        $_SESSION["lastNameUpdateError"] = true;
      }
    }
    if (isset($_POST['editEmployee'], $_POST["staff_pin"], $_POST["department"],
      $_POST["email"], $_POST["first_name"], $_POST["last_name"])
    ) {
      $staff_pin = stripcslashes($_POST['staff_pin']);
      $email = stripcslashes($_POST['email']);
      $first_name = stripcslashes($_POST['first_name']);
      $last_name = stripcslashes($_POST['last_name']);
      $department = stripcslashes($_POST['department']);
      $updateQuery = "UPDATE `users` SET staff_pin='$staff_pin', email='$email',
        first_name='$first_name', last_name='$last_name', department_id='$department' WHERE staff_pin='$staffPin'";
      if ($conn->query($updateQuery) === TRUE) {
        $_SESSION["employeeProfileUpdated"] = true;
        $_POST = NULL;
        header("location: employee-profile.php?e=$staff_pin");
      } elseif (strpos($conn->error, "'staff_pin'") > 0) {
        $_SESSION["staffUpdateDupError"] = true;
      } elseif (strpos($conn->error, "'email'") > 0) {
        $_SESSION["emailUpdateDupError"] = true;
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Employee Profile</title>
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
          <div class="row py-2">
            <div class="col-10 mx-auto">
              <div class="card shadow-lg border-0">
                <div class="card-header">
                  <h3>
                    Edit Employee Profile
                  </h3>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group">
                      <label>Staff Pin:</label>
                      <input type="text" name="staff_pin" value="<?php if(isset($_POST['staff_pin'])){echo($_POST['staff_pin']);}else{echo($staff['staff_pin']);} ?>" required="" class="form-control">
                      <?php
                        // Catch empty field error
                        if (isset($_SESSION["staffUpdateError"]) && ($_SESSION["staffUpdateError"] === true)) {
                          echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          $_SESSION["staffUpdateError"] = NULL;
                        } elseif (isset($_SESSION["staffUpdateDupError"]) && ($_SESSION["staffUpdateDupError"] === true)) {
                          echo '<small class="text-danger"><strong>This staff pin is already in use!</strong></small>';
                          $_SESSION["staffUpdateDupError"] = NULL;
                        }
                      ?>
                    </div>
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="email" name="email" value="<?php if(isset($_POST['email'])){echo($_POST['email']);}else{echo($staff['email']);} ?>" required="" class="form-control">
                      <?php
                        // Catch empty field error
                        if (isset($_SESSION["emailUpdateError"]) && ($_SESSION["emailUpdateError"] === true)) {
                          echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          $_SESSION["emailUpdateError"] = NULL;
                        } elseif (isset($_SESSION["emailUpdateDupError"]) && ($_SESSION["emailUpdateDupError"] === true)) {
                          echo '<small class="text-danger"><strong>This email is already in use!</strong></small>';
                          $_SESSION["emailUpdateDupError"] = NULL;
                        }
                      ?>
                    </div>
                    <div class="form-group">
                      <label>First Name:</label>
                      <input type="text" name="first_name" value="<?php if(isset($_POST['first_name'])){echo($_POST['first_name']);}else{echo($staff['first_name']);} ?>" required="" class="form-control">
                      <?php
                        // Catch empty field error
                        if (isset($_SESSION["firstNameUpdateError"]) && ($_SESSION["firstNameUpdateError"] === true)) {
                          echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          $_SESSION["firstNameUpdateError"] = NULL;
                        }
                      ?>
                    </div>
                    <div class="form-group">
                      <label>Last Name:</label>
                      <input type="text" name="last_name" value="<?php if(isset($_POST['last_name'])){echo($_POST['last_name']);}else{echo($staff['last_name']);} ?>" required="" class="form-control">
                      <?php
                        // Catch empty field error
                        if (isset($_SESSION["lastNameUpdateError"]) && ($_SESSION["lastNameUpdateError"] === true)) {
                          echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          $_SESSION["lastNameUpdateError"] = NULL;
                        }
                      ?>
                    </div>
                    <div class="form-group">
                      <label>Department:</label>
                      <select class="form-control" required="" name="department">
                        <option value="">-- Choose Department --</option>
                        <?php
                          foreach ($departments as $department) {
                            if (isset($_POST['department']) && ($_POST['department'] == $department["id"])) {
                              echo '<option value="' . $department["id"] . '" selected="">' . $department["name"] . '</option>';
                            } elseif ($staff['department_id'] == $department["id"]) {
                              echo '<option value="' . $department["id"] . '" selected="">' . $department["name"] . '</option>';
                            } else {
                              echo '<option value="' . $department["id"] . '">' . $department["name"] . '</option>';
                            }
                          }
                        ?>
                      </select>
                      <?php
                        // Catch empty field error
                        if (isset($_SESSION["deptUpdateError"]) && ($_SESSION["deptUpdateError"] === true)) {
                          echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                          $_SESSION["deptUpdateError"] = NULL;
                        }
                      ?>
                    </div>
                    <div class="modal-footer border-0">
                      <?php
                        echo '<a class="btn btn-outline-dark" href="employee-profile.php?e=' . $staffPin . '">CANCEL</a>';
                      ?>
                      <button type="submit" name="editEmployee" class="btn btn-dark">
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
  </body>
  <style>
    body {
      background-color: #f4f3f4 !important;
    }
  </style>
</html>