<?php require_once('func/settings.php'); ?>
<!-- BEGIN HEADER -->
<header class="main-header">
  <nav class="search-bar">

    <ul class="topnav home">
      <li><a href="index.php"><?= SITE_NAME ?></a></li>
      <li><a href="index.php">Home</a></li>
    </ul>

    <form>
      <label>
        The Web
        <input type="radio" name="search-type" value="the-web">
      </label>

      <label>
      <?= htmlspecialchars(SITE_NAME); ?>
        <input type="radio" name="search-type" value="anyspace">
      </label>

      <label>
        <input type="text" name="search">
      </label>

      <input class="submit-btn" type="submit" name="submit-button" value="Search">
    </form>

    <ul class="topnav signup">
    <?php if (isset($_SESSION['user'])): ?>
      <li><a href="help.php">Help</a></li>
      <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="help.php">Help</a></li>
      <li><a href="register.php">SignUp</a></li>
    <?php endif; ?>
  </ul>
  </nav>

  <nav class="navbar">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="browse.php">Browse</a></li>
      <li><a href="search.php">Search</a></li>
      <li><a href="#">Invite</a></li>
      <li><a href="#">Board</a></li>
      <li><a href="#">Mail</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Bulletins</a></li>
      <li><a href="#">Forum</a></li>
      <li><a href="#">Groups</a></li>
      <li><a href="#">Skins</a></li>
      <li><a href="#">Apply</a></li>
      <li><a href="#">Shop</a></li>
      <li><a href="#">About</a></li>
    </ul>
  </nav>

</header>
<!-- END HEADER -->