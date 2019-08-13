<!DOCTYPE html>
<html>
  <head>
    <title>New Leave Application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../static/css/bootstrap.min.css">
    <script src="../static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../static/js/popper.min.js"></script>
    <script src="../static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="dashboard.php">Leave MS</a>
      <ul class="navbar-nav offset-md-8 offset-1 mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="profile.php">My profile</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 mx-auto">
          <div class="row py-2">
            <div class="col-sm-12 col-md-10 mx-auto">
               <div class="card shadow-lg border-0">
                  <div class="card-header">
                    <h3>
                      New Leave Application
                    </h3>
                  </div>
                  <div class="card-body">
                    <form>
                      <div class="form-group">
                        <label>Purpose:</label>
                        <input type="text" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Start Date:</label>
                        <input type="date" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>End Date:</label>
                        <input type="date" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Extra information:</label>
                        <textarea class="form-control" rows="3"></textarea>
                      </div>
                      <!-- Modal footer -->
                      <div class="modal-footer border-0">
                        <button class="btn btn-outline-secondary">
                          CANCEL
                        </button>
                        <button class="btn btn-dark">
                          APPLY FOR LEAVE
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
  </body>
  <style>
    body {
      background-color: #f4f3f4 !important;
    }
  </style>
</html>