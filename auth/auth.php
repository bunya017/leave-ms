<?php
  if (!isset($_SESSION["isLoggedIn"])) {
    header("location: ../index.php");
  }
?>