<!DOCTYPE html>
<html>
  <head>
    <title>Profile</title>
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
          <a class="nav-link" href="">My profile</a>
        </li>
      </ul>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-10 mx-auto">
          <!-- Profile details card -->
          <div class="row py-5">
            <div class="col-10 mx-auto">
              <div class="card shadow-lg border-0 pb-3">
                <div class="card-header">
                  <h2>
                    Profile Details
                    <div class="float-right">
                      <button class="btn btn-outline-dark mx-1" data-toggle="modal" data-target="#profileUpdateModal">
                        EDIT PROFILE
                      </button>
                      <button class="btn btn-outline-dark mx-1" data-toggle="modal" data-target="#passwordChangeModal">
                        CHANGE PASSWORD
                      </button>
                    </div>
                  </h2>
                </div>
                <div class="card-body">
                  <div class="row py-1">
                    <h4 class="col-6">Staff Pin</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">COSC0001</span>
                    </h4>
                  </div>
                  <div class="row py-1">
                    <h4 class="col-6">Email</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">janemikel@email.com</span>
                    </h4>
                  </div>
                  <div class="row py-1">
                    <h4 class="col-6">First Name</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">Jane</span>
                    </h4>
                  </div>
                  <div class="row py-1">
                    <h4 class="col-6">Last Name</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">Mikel</span>
                    </h4>
                  </div>
                  <div class="row py-1">
                    <h4 class="col-6">Total Leave Days</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">30</span>
                    </h4>
                  </div>
                  <div class="row py-1">
                    <h4 class="col-6">Leave Days Remaining</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">16</span>
                    </h4>
                  </div>
                  <div class="row py-1">
                    <h4 class="col-6">Last Profile Update Date</h4>
                    <h4 class="col-6">
                      <span class="font-weight-light">02-Jul-2019</span>
                    </h4>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Profile update Modal -->
          <div class="modal" id="profileUpdateModal" data-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Update Profile Details</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form>
                        <div class="form-group">
                          <label>Usernname:</label>
                          <input type="text" disabled="" value="username" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Email:</label>
                          <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>First Name:</label>
                          <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>Last Name:</label>
                          <input type="text" class="form-control">
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            CANCEL
                          </button>
                          <button type="button" class="btn btn-dark" data-dismiss="modal">
                            UPDATE PROFILE
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Change Password Modal -->
          <div class="modal" id="passwordChangeModal" data-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Change Password</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                  <div class="row">
                    <div class="col-11 mx-auto">
                      <form>
                        <div class="form-group">
                          <label>Old password:</label>
                          <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>New password:</label>
                          <input type="text" class="form-control">
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer border-0">
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            CANCEL
                          </button>
                          <button type="button" class="btn btn-dark" data-dismiss="modal">
                            CHANGE PASSWORD
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