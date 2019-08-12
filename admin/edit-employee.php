<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staff = $_GET['e'];
    $query = "SELECT * FROM `users` JOIN `departments` WHERE `users`.`staff_pin`='$staff'";
    $result = $conn->query($query);
    echo $conn->error;
    if (($result->num_rows > 0)){
      $staff = $result->fetch_assoc();
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
                      <input type="text" name="staff_pin" value="<?php if(isset($_POST['staff_pin'])){echo($_POST['staff_pin']);}else{echo($staff['staff_pin']);} ?>" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="text" name="email" value="<?php if(isset($_POST['email'])){echo($_POST['email']);}else{echo($staff['email']);} ?>" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>First Name:</label>
                      <input type="text" name="first_name" value="<?php if(isset($_POST['first_name'])){echo($_POST['first_name']);}else{echo($staff['first_name']);} ?>" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Last Name:</label>
                      <input type="text" name="last_name" value="<?php if(isset($_POST['last_name'])){echo($_POST['last_name']);}else{echo($staff['last_name']);} ?>" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Department:</label>
                      <select class="form-control" required="" name="department">
                        <option value="">-- Choose Department --</option>
                        <?php
                          if ($result->num_rows > 0) {
                            while ($departments = $result->fetch_assoc()) {
                              if (isset($_POST['department']) && ($_POST['department'] == $departments["id"])) {
                                echo '<option value="' . $departments["id"] . '" selected="">' . $departments["name"] . '</option>';
                              } elseif ($staff['department_id'] == $departments["id"]) {
                                echo '<option value="' . $departments["id"] . '" selected="">' . $departments["name"] . '</option>';
                              } else {
                                echo '<option value="' . $departments["id"] . '">' . $departments["name"] . '</option>';
                              }
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <div class="modal-footer border-0">
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
</html>