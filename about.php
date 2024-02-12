<?php
require("core/conn.php");
require_once("core/settings.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

?>
<?php require("header.php"); ?>

<div class="simple-container">
    <h1>About <?= SITE_NAME ?></h1>


</div>

<?php require("footer.php"); ?>