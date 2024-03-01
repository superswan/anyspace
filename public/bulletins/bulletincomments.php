<?php
require("../../core/conn.php");
require_once("../../core/settings.php");
require("../../core/site/user.php"); 
require("../../core/site/comment.php");

login_check();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit; 
}

$userId = $_SESSION['userId'];

$toid = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Ensure you validate and sanitize input
$bulletinComments = fetchBulletinComments($toid);
$comments = $bulletinComments;
$commentType = 'bulletin';

?>

<?php require_once("bulletins-header.php") ?>

<div class="simple-container">
    <h1>Comments</h1>
    <p><a href="bulletin.php?id=<?= $toid ?>">&laquo; Back to Bulletin</a></p>
    <br>
    <?php include("../../core/components/comments_table.php") ?>
</div>

<?php require_once("../footer.php") ?>