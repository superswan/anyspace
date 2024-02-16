<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/user.php");

login_check();

$userId = $_SESSION['userId'];

$favoritesArray = fetchFavorites($userId);
$favorites =json_decode($favoritesArray, true);

?>
<?php require("header.php"); ?>
<div class="simple-container">
  <h1>Your Favorites</h1>
  <p class="info">Click on <b><img src="static/icons/award_star_add.png" class="icon" aria-hidden="true" loading="lazy" alt=""> Add to Favorites</b> on any profile to add a user to this list.</p>
  <div class="new-people">
    <div class="top">
      <h4>Favorite Users</h4>
      <!--
      <a class="more" href="#">View Favorite Layouts</a>
      -->
    </div>
    <div class="inner">
    <?php if ($favorites): ?>
        <?php 
            foreach ($favorites as $favorite) { 
                printPerson($favorite);
            }
        ?>
    <?php else: ?>
      <p><i>You haven't added any Users to your Favorites yet.</i></p>    </div>
    <?php endif; ?>
  </div>
</div>

<?php require("footer.php"); ?>