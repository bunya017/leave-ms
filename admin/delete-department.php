<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $dept_id = $_GET["id"];
    $dept_short_code = $_GET["sc"];
    $query = "DELETE FROM `departments` WHERE id='$dept_id' AND short_code='$dept_short_code'";
    if ($conn->query($query) === TRUE) {
      $_SESSION["deptDeleted"] = true;
      header("location: departments.php");
    } else {
      header("location: departments.php");
    }
  }
?>