<html>
  <head>
    <title>Register</title>
    <link rel="stylesheet" href="static/css/form_log.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  </head>
  <body>
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
    <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <div class="content">
        <div class="top_login">
          <h1>Register Here</h1>
        </div>
        <input type="text" name="text" placeholder="username" class="input">
        <input type="email" name="email" placeholder="Email" class="input">
        <input type="password" name="password" placeholder="Password" class="input">
        <button class="button" type="submit">Submit</button>
      </div>
    </form>
  </div>
  </body>
</html>