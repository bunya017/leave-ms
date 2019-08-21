<?php
  session_start();
  require("../config.php");
  require("../auth/auth.php");
  require("../auth/permissions.php");
  require("../auth/admin-permissions.php");
  if (isset($_SESSION["isLoggedIn"]) and ($_SESSION["isLoggedIn"] === TRUE)) {
    $query = "SELECT * FROM `leave_types`";
    $result = $conn->query($query);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Leave Types</title>
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
      <!-- Employee section -->
      <div class="row py-4">
        <div class="col-10 mx-auto">
          <?php
            if (isset($_SESSION["leaveCreated"]) && ($_SESSION["leaveCreated"] === true)) {
              echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button class="close" data-dismiss="alert">&times;</button>Leave added successfully!</div></div>';
              $_SESSION["leaveCreated"] = NULL;
            } elseif (isset($_SESSION["leaveDeleted"]) && ($_SESSION["leaveDeleted"] === true)) {
              echo '<div class="col-8 mx-auto"><div class="alert alert-success alert-dismissible text-center"><button class="close" data-dismiss="alert">&times;</button>Leave deleted successfully!</div></div>';
              $_SESSION["leaveDeleted"] = NULL;
            }
          ?>
          <!-- Title -->
          <div class="row align-items-center py-3">
            <div class="col-6">
              <h2>Leave Types</h2>
            </div>
            <div class="col-6">
              <a class="btn btn-dark float-right" href="add-leave.php">
                ADD LEAVE TYPE
              </a>
            </div>
          </div>
          <?php if ($result->num_rows > 0): ?>
            <!-- Employee list -->
            <div class="row">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Leave Type</th>
                    <th>Description</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Show Departments
                    $index = 0;
                    while ($row = $result->fetch_assoc()) {
                      ++$index;
                      echo "<tr>";
                      echo "<td>" . $index . "</td>";
                      echo "<td>" . $row["leave_type"] . "</td>";
                      if (empty($row["description"]) === TRUE) {
                        echo "<td><i>No description.</i></td>";
                      } else {
                        echo "<td>" . $row["description"] . "</td>";
                      }
                      echo '
                      <td>
                        <a class="btn btn-outline-danger btn-sm" href="delete-leave.php?id=' . $row['id'] . '&lt=' . $row['leave_type'] . '">
                          DELETE
                        </a>
                      </td>
                      ';
                      echo "</tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="col-12 py-4 text-center">
              <p class="lead large">You have 0 leave leave types, please click the "ADD LEAVE TYPE" button to get started.</p>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </body>
  <style>
    body {
      background-color: #f4f3f4 !important;
    }

    .large {
      font-size: 1.75em;
    }
  </style>
  <script>
    setTimeout(function () { // Hide alert after 5 seconds
        $(".alert").alert('close');
      }, 5000
    );
  </script>
</html>