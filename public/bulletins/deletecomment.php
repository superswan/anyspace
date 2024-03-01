<?php
require("../../core/conn.php");
require_once("../../core/settings.php");
require_once("../../core/site/comment.php");

login_check();

$user = $_SESSION['user'];
$userId = $_SESSION['userId'];

$commentId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$commentId) {
    header("Location: index.php");
    exit;
}

$comment = fetchBulletinComment($commentId);
$authorId = $comment['author'];

$isUserAuthor = ($userId == $authorId);

// We don't want to offer the delete page to non-authors. the deleteComment() function also checks whether the user
// making the action is the author in the sql statement
if (!$isUserAuthor) {
    header("Location: comments.php?id=" . $comment['toid']);
    exit;
} else { 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $confirmation = isset($_POST['confirmation']) ? strtoupper(trim($_POST['confirmation'])) : '';
        if ($confirmation == 'DELETE') {
            deleteBulletinComment($commentId, $userId);
            header("Location: bulletincomments.php?id=" . $comment['toid'] );
        exit;
    }
}
}
?>
<?php require("bulletins-header.php"); ?>

<div class="simple-container">
    <h1>Confirm Deletion</h1>
    <form method="POST" action="">
        <p>Type "DELETE" to confirm the deletion of the comment:</p>
        <input type="text" name="confirmation" required>
        <button type="submit" name="submit">Delete</button>
        <button onclick="location.href='comments.php?id=<?= $comment['toid'] ?>'; return false;" type="button" name="cancel">Cancel</button>
    </form>
</div>
<?php require("../footer.php"); ?>

</body>

</html>