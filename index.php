<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-5" href="">
        Leave MS
      </a>
    </nav>
    <div class="container">
      <div class="row py-5">
        <div class="col-5 mx-auto">
          <div class="card border-0 shadow-lg">
            <div class="card-body">
              <div>
                <h3 class="text-center">Login</h3>
              </div>
              <div class="row py-5">
                <div class="col-11 mx-auto">
                  <form method="post">
                    <div class="form-group">
                      <label>Email:</label>
                      <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Password:</label>
                      <input type="password" name="password" class="form-control">
                    </div>
                    <div class="py-3">
                      <button class="col-6 btn btn-dark" name="submit">
                        LOGIN
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