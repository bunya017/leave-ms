<!DOCTYPE html>
<html>
  <head>
    <title>Leave Applications</title>
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
      <a class="navbar-brand ml-auto" href="">
        Leave MS <span class="badge badge-info">Admin</span>
      </a>
      <ul class="navbar-nav offset-md-6 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="employees.html">Employees</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">Leave Applications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="departments.html">Departments</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <!-- Employee Leave section -->
      <div class="row py-4">
        <div class="col-10 mx-auto">
          <!-- Title -->
          <div class="row align-items-center pb-4">
            <div class="col-6">
              <h2>Employee Leave Applications</h2>
            </div>
          </div>

          <!-- Employee Leave list -->
          <div class="row">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Employee</th>
                  <th>Applictaion Date</th>
                  <th>Purpose</th>
                  <th>Period</th>
                  <th>Approval Date</th>
                  <th>Approval Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Jane Mikel</td>
                  <td>02-Aug-2019</td>
                  <td>Weekend</td>
                  <td>2 Days</td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td><span class="badge badge-warning">Pending</span></td>
                  <td>
                    <a class="btn btn-outline-dark btn-sm" href="employee-leave-detail.html">VIEW</a>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Jane Mikel</td>
                  <td>22-Jan-2019</td>
                  <td>Maternity</td>
                  <td>14 Days</td>
                  <td>25-Jan-2019</td>
                  <td><span class="badge badge-success">Approved</span></td>
                  <td>
                    <a class="btn btn-outline-dark btn-sm" href="employee-leave-detail.html">VIEW</a>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Jane Mikel</td>
                  <td>12-Jul-2018</td>
                  <td>Chilling</td>
                  <td>12 Days</td>
                  <td>14-Jul-2018</td>
                  <td><span class="badge badge-danger">Disapproved</span></td>
                  <td>
                    <a class="btn btn-outline-dark btn-sm" href="employee-leave-detail.html">VIEW</a>
                  </td>
                </tr>
              </tbody>
            </table>
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