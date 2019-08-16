<?php
  session_start();
  if (!isset($_SESSION["isLoggedIn"])) {
    header("location: ../index.php");
  }
?>