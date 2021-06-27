<?php 
  session_start();
  require_once "tools.php";
  check_timeout();
?>

<script src="https://skrypt-cookies.pl/id/467fa61a23304e5a.js"></script>

<header>
  <img id="logo" src="../img/pwr.png" alt="logoPwr">
  <h1>Basic HTML Stuff</h1>
  <p><cite>Literka P, literka W, literka R, jak PWR</cite></p>
</header>

<nav>
  <button id="hamburger">
    <div class="line_in_button"></div>
    <div class="line_in_button"></div>
    <div class="line_in_button"></div>
  </button>
  <div id="menu_options">
    <a href="./index.php">About</a>
    <a href="./science.php">Zainteresowania naukowe</a>
    <a href="./hobby.php">Sprawy pozanaukowe</a>
    <a href="./grid_test.php">Grid Fun</a>
    <div>
      <?php
        if ( isset($_SESSION['id']) && isset($_SESSION['user']) ){
          echo '<a style="background-color: blue">Witaj '.'<span style="color: yellow">'.$_SESSION['user'].'</span>'.'</a>';
          echo '<a href="./logout.php">Logout</a>';
        }
        else{
          echo '<a href="./login.php">Login</a>';
        }
      ?>
    </div>
  </div>
</nav>