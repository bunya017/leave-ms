<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $staffPin = $_GET['e'];
    $query = "DELETE FROM `users` WHERE staff_pin='$staffPin'";
    if ($conn->query($query) === TRUE) {
      $_SESSION["employeeDeleted"] = true;
      header("location: employees.php");
    } else {
      header("location: employees.php");
    }
  }
?>