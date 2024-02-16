<?php
require_once("../core/conn.php");
require_once("../core/settings.php");
require("../core/site/user.php"); 
require("../core/site/comment.php");

login_check();

$userId = $_SESSION['userId']; //needed by ../core/components/comments_table.php
$toid = isset($_GET['id']) ? (int)$_GET['id'] : 0; 
$comments = fetchComments($toid);

?>

<?php require_once("header.php") ?>

<div class="simple-container">
    <h1><?= fetchName($toid) ?>'s Friends Comments</h1>
    <p><a href="profile.php?id=<?= $toid ?>">&laquo; Back to <?= fetchName($toid) ?>'s Profile</a></p>
    <br>
    <?php include "../core/components/comments_table.php" ?>
</div>

<?php require_once("footer.php") ?>