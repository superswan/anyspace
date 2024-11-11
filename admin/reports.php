<?php
// Site functions
require("../core/conn.php");
require_once("../core/settings.php");

// Page functions
require("../core/site/user.php");

login_check();

?>
<?php require("header.php"); ?>
<?php require("../public/footer.php"); ?>