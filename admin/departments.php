<!DOCTYPE html>
<html>
  <head>
    <title>Departments</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php
      session_start();
      var_dump($_SESSION);
    ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="dashboard.php">
        Leave MS <span class="badge badge-info">Admin</span>
      </a>
      <ul class="navbar-nav offset-md-6 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="employees.html">Employees</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="employee-leave.html">Leave Applications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">Departments</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <!-- Employee section -->
      <div class="row py-4">
        <div class="col-10 mx-auto">
          <!-- Title -->
          <div class="row align-items-center py-3">
            <div class="col-6">
              <h2>Departments</h2>
            </div>
            <div class="col-6">
              <button type="button" class="btn btn-dark float-right" data-toggle="modal" data-target="#addDepartmentModal">
                ADD DEPARTMENT
              </button>
            </div>
          </div>

          <!-- Employee list -->
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Short Code</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Computer Engineering</td>
                  <td>COSC</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Computer Science</td>
                  <td>COEN</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Add Employee Modal -->
          <div class="modal" id="addDepartmentModal" data-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Add New Department</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form>
                        <div class="form-group">
                          <label>Name:</label>
                          <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Short Code:</label>
                          <input type="text" class="form-control">
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            CANCEL
                          </button>
                          <button type="button" class="btn btn-dark" data-dismiss="modal">
                            ADD DEPARTMENT
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
      </div>
    </div>
  </body>
  <style>
    body {
      background-color: #f4f3f4 !important;
    }
  </style>
</html>