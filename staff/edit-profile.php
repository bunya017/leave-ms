<?php
  session_start();
  require("../config.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staff = $_SESSION["staff_pin"];
    $query = "SELECT * FROM `users` WHERE staff_pin='$staff'";
    $result = $conn->query($query);
    if (isset($_POST['editStaffProfile'])) {
      if (empty($_POST["email"])) {
        $_SESSION["emailEditError"] = true;
      }
      if (empty($_POST["first_name"])) {
        $_SESSION["firstNameEditError"] = true;
      }
      if (empty($_POST["last_name"])) {
        $_SESSION["lastNameEditError"] = true;
      }
    }
    if (isset($_POST['editStaffProfile'], $_POST["email"], $_POST["first_name"], $_POST["last_name"])) {
      $email = stripcslashes($_POST['email']);
      $first_name = stripcslashes($_POST['first_name']);
      $last_name = stripcslashes($_POST['last_name']);
      $profileUpdateQuery = "UPDATE `users` SET email='$email', first_name='$first_name', last_name='$last_name'
        WHERE staff_pin='$staff'";
      if ($conn->query($profileUpdateQuery) === TRUE) {
        $_SESSION["staffProfileEdited"] = true;
        $_POST = NULL;
        header("location: profile.php");
      } elseif (strpos($conn->error, "'email'") > 0) {
        $_SESSION["emailEditDupError"] = true;
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Profile</title>
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
              <?php if ($result->num_rows > 0): $row = $result->fetch_assoc();?>
                <div class="card shadow-lg border-0">
                  <div class="card-header">
                    <h3>
                      Edit Profile Details
                    </h3>
                  </div>
                  <div class="card-body">
                    <form method="post">
                      <div class="form-group">
                        <label>Staff Pin:</label>
                        <input type="text" disabled="" value="<?php echo $staff ?>" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" required="" value="<?php if(isset($_POST['email'])){echo($_POST['email']);}else{echo($row['email']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["emailEditError"]) && ($_SESSION["emailEditError"] === true)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["emailEditError"] = NULL;
                          } elseif (isset($_SESSION["emailEditDupError"]) && ($_SESSION["emailEditDupError"] === true)) {
                            echo '<small class="text-danger"><strong>This email is already in use!</strong></small>';
                            $_SESSION["emailEditDupError"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>First Name:</label>
                        <input type="text" name="first_name" required="" value="<?php if(isset($_POST['first_name'])){echo($_POST['first_name']);}else{echo($row['first_name']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["firstNameEditError"]) && ($_SESSION["firstNameEditError"] === true)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["firstNameEditError"] = NULL;
                          }
                        ?>
                      </div>
                      <div class="form-group">
                        <label>Last Name:</label>
                        <input type="text" name="last_name" required="" value="<?php if(isset($_POST['last_name'])){echo($_POST['last_name']);}else{echo($row['last_name']);} ?>" class="form-control">
                        <?php
                          // Catch empty field error
                          if (isset($_SESSION["lastNameEditError"]) && ($_SESSION["lastNameEditError"] === true)) {
                            echo '<small class="text-danger"><strong>This field is required!</strong></small>';
                            $_SESSION["lastNameEditError"] = NULL;
                          }
                        ?>
                      </div>
                      <!-- Modal footer -->
                      <div class="modal-footer border-0">
                        <a class="btn btn-outline-secondary" href="profile.php">
                          CANCEL
                        </a>
                        <button type="submit" name="editStaffProfile" class="btn btn-dark">
                          UPDATE PROFILE
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              <?php else: ?>
                <div class="col-12 mt-5 text-center">
                  <h1 class="text-dark display-1">404</h1>
                  <p class="lead pb-3">We can't seem to find the page you're looking for.</p>
                  <ul class="list-inline">
                    <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="dashboard.php">Back to Home</a>
                    <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="employees.php">Employees</a>
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