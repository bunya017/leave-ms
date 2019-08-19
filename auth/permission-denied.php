<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>403</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-10 mx-auto">
          <div class="row py-5">
            <div class="col-12 mt-5 text-center">
              <h1 class="text-dark font-weight-bold display-1">403</h1>
              <p class="lead display-4 pb-3">Permission Denied.</p>
              <ul class="list-inline">
                <?php
                  if ($_SESSION["role"] === "staff") {
                    echo '
                      <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="../staff/dashboard.php">
                        Dashboard
                      </a>
                      <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="../logout.php">
                        Logout
                      </a>
                    ';
                  } elseif (($_SESSION["role"] != "staff") && (!empty($_SESSION["role"]) === TRUE)) {
                    echo '
                      <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="../admin/dashboard.php">
                        Dashboard
                      </a>
                      <a class="btn btn-outline-dark btn-sm mx-1 list-inline-item" href="../logout.php">
                        Logout
                      </a>
                    ';
                  }
                ?>
              </ul>
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