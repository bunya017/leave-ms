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
                      <input type="text" name="staff_pin" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="text" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>First Name:</label>
                      <input type="text" name="first_name" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Last Name:</label>
                      <input type="text" name="last_name" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Department:</label>
                      <input type="text" name="department" class="form-control">
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