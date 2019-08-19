<?php
  echo '
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <a class="navbar-brand ml-auto" href="dashboard.php">Leave MS</a>
      <ul class="navbar-nav offset-md-8 offset-1 mr-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Account
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="change-password.php">Change password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </nav>
  ';
?>