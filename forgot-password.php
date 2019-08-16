<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Reset your password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <script src="static/js/jquery-3.3.1.slim.min.js"></script>
    <script src="static/js/popper.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-5" href="index.php">
        Leave MS
      </a>
    </nav>
    <div class="container">
      <div class="row py-5">
        <div class="col-5 mx-auto">
          <div class="card border-0 shadow-lg">
            <div class="card-body">
              <div class="row pb-5 pt-4">
                <div class="col-11 mx-auto">
                  <div class="text-center">
                    <h3>Reset your password</h3>
                    <small>Enter your email address and we will send you a link to reset your password.</small>
                  </div>
                  <form class="pt-4">
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="email" name="email" required="" class="form-control">
                    </div>
                    <div class="py-3">
                      <button class="col-12 btn btn-dark" name="resetPassword">
                        SEND PASSWORD RESET EMAIL
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
  <style>
    body {
      background-color: #f4f3f4;
    }
  </style>
</html>