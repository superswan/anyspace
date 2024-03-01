<?php
require("../../core/conn.php");
require_once("../../core/settings.php");
require("../../core/site/user.php");
require("../../core/site/comment.php");

if (!isset($_SESSION['userId'])) {
    $userId = null;
} else {
    $userId = $_SESSION['userId'];
}


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
} else {
    $toid = $_GET['id']; 
}

$blogComments = fetchBlogComments($toid);
$comments = $blogComments;
$commentType = 'blog';
?>

<?php require_once("blog-header.php") ?>

<div class="simple-container">
    <h1>Comments</h1>
    <p><a href="entry.php?id=<?= $toid ?>">&laquo; Back to Blog Entry</a></p>
    <br>
    <?php include("../../core/components/comments_table.php"); ?>

</div>

<?php require_once("../footer.php") ?>