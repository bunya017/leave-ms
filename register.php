<html>
  <head>
    <title>Register</title>
    <link rel="stylesheet" href="static/css/form_log.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  </head>
  <body>
    <?php
      require("config.php");
      if (isset($_POST["submit"])) {
        $username = stripcslashes($_POST["username"]);
        $email = stripcslashes($_POST["email"]);
        $password = password_hash(
          stripcslashes($_POST["password"]), PASSWORD_DEFAULT
        );
        $query = "INSERT into `users` (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($query) === TRUE) {
          echo "<br>Created user<br>";
        } else {
          echo "<br>" . $conn->error;
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
        
        <li><a href="register.html" class="regester">Register</a></li>
        <li><a href="About_Us.html">About Us</a></li>
        <li><a href="">Contact Us</a></li>
      </ul>
    </div>
    </br>
    <!-- Signup form -->
    <form class="form" method="post">
      <div class="content">
        <div class="top_login">
          <h1>Register Here</h1>
        </div>
        <input type="text" required="" name="username" placeholder="Username" class="input">
        <input type="email" required="" name="email" placeholder="Email" class="input">
        <input type="password" required="" name="password" placeholder="Password" class="input">
        <button class="button" type="submit" name="submit">Submit</button>
      </div>
    </form>
  </div>
  </body>
</html>