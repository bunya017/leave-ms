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
    ?>
    <div>
      <img src="media/ICICT.jpg" alt="LOGO" class="logo">
      </div>  
      <div class="nav_container">
        <ul class="navbar">
          <li><a href="home.html">Home</a></li>
          <li><a href="register.html">Register</a></li>
          <li><a href="About_Us.html">About Us</a></li>
          <li><a href="">Contact Us</a></li>
        </ul>
      </div>
      </br> 
      <form class="form">
        <div class="top_container">
        </div>
        <div class="content">
          <div class="top_login">
            <h1>Employee Login</h1>
          </div>  
          <input type="email" required="" name="email" placeholder="Email" class="input">
          <input type="password" required="" name="password" placeholder="Password" class="input">
          <button class="button" type="Submit" name="submit">Submit</button>
        </div>
      </form>
    </div>
  </body>
</html>