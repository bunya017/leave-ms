<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $leave_id = $_GET["id"];
    $leave_type = $_GET["lt"];
    $query = "DELETE FROM `leave_types` WHERE id='$leave_id' AND leave_type='$leave_type'";
    if ($conn->query($query) === TRUE) {
      $_SESSION["leaveDeleted"] = true;
      header("location: leave-types.php");
    } else {
      header("location: leave-types.php");
    }
  }
?>