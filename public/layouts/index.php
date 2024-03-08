<?php
require("../../core/conn.php");
require_once("../../core/settings.php");


?>
<!DOCTYPE html>
<html>

<head>
    <title>Bulletin Board | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/static/css/normalize.min.css">
    <link rel="stylesheet" href="/static/css/style.min.css">
</head>

<body>
    <div class="master-container">
        <header class="main-header">
  <nav class="">
    <div class="top">
      <div class="left">
        <a href="index.php">
            <?= SITE_NAME ?>
          </a> | <a href="index.php">Bulletin Board</a>
      </ul>
    </div>
    <div class="center">

      <form>
        <label>
          <?= htmlspecialchars(SITE_NAME); ?>
        </label>

        <label>
          <input type="text" name="search">
        </label>

        <input class="submit-btn" type="submit" name="submit-button" value="Search">
      </form>
</div>
  <div class="right">
      <ul class="topnav signup">
        <?php if (isset($_SESSION['user'])): ?>
          <a href="/docs/help.html">Help</a> | <a href="/logout.php">LogOut</a>
        <?php else: ?>
          <a href="/docs/help.html">Help</a> |
          <a href="/docs/help.html">LogIn</a> |
          <a href="register.php">SignUp</a>
        <?php endif; ?>
      </ul>
        </div>
    </div>
    <ul class="links">
      <?php
      $currentPage = basename($_SERVER['SCRIPT_FILENAME']);

      $isHomePage = in_array($currentPage, array('index.php', 'home.php'));

      $navItems = array(
        'Home' => '../index.php',
        'Browse' => '../browse.php',
        'Search' => '../search.php',
        'Board' => '../futaba.php',
        'Mail' => '../messages.php',
        'Blog' => '../blog/',
        'Bulletins' => '../bulletins/',
        'Forum' => '../forum.php',
        'Groups' => '#',
        'Layouts' => '../layouts/',
        'Favs' => '../favorites.php',
        'Source' => 'https://github.com/superswan/anyspace',
        'Help' => '../docs/help.html',
        'About' => '../about.php',
      );

      foreach ($navItems as $name => $page) {
        if ($name == 'Layouts' && $isHomePage) {
          $activeClass = 'class="active"';
        } else {
          $activeClass = ($name == 'Layouts') ? 'class="active"' : '';
        }
        echo "<li><a href=\"$page\" $activeClass>&nbsp$name</a></li>";
      }
      ?>
    </ul>
  </nav>

</header>
        <main>
<div class="simple-container">
    <h1>Coming Soon!</h1>


</div>

<?php require("../footer.php"); ?>