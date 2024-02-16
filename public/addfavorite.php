<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/user.php");

login_check();

$userId = $_SESSION['userId'];

$profileId = $_GET['id']; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    addFavorite($userId, $profileId);
    header("Location: favorites.php");
    exit;
}

?>
<?php require("header.php"); ?>
<div class="simple-container">
  <h1><img src="static/icons/award_star_add.png" class="icon" aria-hidden="true" loading="lazy" alt=""> Add Favorite</h1>
      <p>Do you want to add this user to your Favorites?</p>
    <form method="post">
      <button type="submit" name="submit">Add to Favorites</button>
      <form>
            <a href="profile.php?id=<?= $profileId ?>"><button type="button">Go Back</button></a>
</div>

<?php require("footer.php"); ?>