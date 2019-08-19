<?php
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    if ($_SESSION["role"] === "staff") {
      header("location: ../auth/permission-denied.php");
    }
  }
?>