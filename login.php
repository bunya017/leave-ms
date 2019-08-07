<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="static/css/form_log.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  </head>
  <body>
    <?php
      require("config.php");
      if (isset($_POST["submit"])) {
        $username = stripcslashes($_POST["username"]);
        $password = stripcslashes($_POST["password"]);
        $query = "SELECT * FROM `users` WHERE username='$username'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          if (password_verify($password, $row["password"]) === TRUE) {
            echo "Logged in<br>";
          } else {
            echo "Not found<br>";
          }
        }
      }
    ?>
    <div>
      <img src="media/ICICT.jpg" alt="LOGO" class="logo">
      </div>
      <!-- Nav -->
      <div class="nav_container">
        <ul class="navbar">
          <li><a href="home.html">Home</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="About_Us.html">About Us</a></li>
        </ul>
      </div>
      </br>
      <!-- Login form --> 
      <form class="form" method="post">
        <div class="top_container">
        </div>
        <div class="content">
          <div class="top_login">
            <h1>Employee Login</h1>
          </div>  
          <input type="tex" required="" name="username" placeholder="Username" class="input">
          <input type="password" required="" name="password" placeholder="Password" class="input">
          <button class="button" type="submit" name="submit">Submit</button>
        </div>
      </form>
    </div>
  </body>
</html>