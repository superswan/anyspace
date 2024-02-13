<!-- BEGIN HEADER -->
<header class="main-header">
  <nav class="">
    <div class="top">
      <div class="left">
        <a href="index.php">
            <?= SITE_NAME ?>
          </a> | <a href="index.php">Home</a>
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
          <a href="docs/help.html">Help</a> | <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="docs/help.html">Help</a> |
          <a href="register.php">SignUp</a>
        <?php endif; ?>
      </ul>
        </div>
    </div>
    <ul class="links">
      <?php
      $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $currentPage = basename($currentUrl);

      $isHomePage = in_array($currentPage, array('index.php', 'home.php'));

      $navItems = array(
        'Home' => 'index.php',
        'Browse' => 'browse.php',
        'Search' => 'search.php',
        'Board' => 'futaba.php',
        'Mail' => 'messages.php',
        'Blog' => 'blog/',
        'Bulletins' => 'bulletins/',
        'Forum' => 'forum.php',
        'Groups' => '#',
        'Layouts' => '#',
        'Favs' => 'favorites.php',
        'Source' => 'https://github.com/superswan/anyspace',
        'Help' => 'docs/help.html',
        'About' => 'about.php',
      );

      foreach ($navItems as $name => $page) {
        if ($name == 'Home' && $isHomePage) {
          $activeClass = 'class="active"';
        } else {
          $activeClass = ($currentPage == basename($page)) ? 'class="active"' : '';
        }
        echo "<li><a href=\"$page\" $activeClass>&nbsp;$name </a></li>";
      }
      ?>
    </ul>
  </nav>



</header>
<!-- END HEADER -->