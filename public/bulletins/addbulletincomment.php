<?php
require_once("../../core/conn.php");
require_once("../../core/settings.php");
require("../../core/site/user.php"); 
require("../../core/site/comment.php");

login_check();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit; 
}

$toid = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// May need to add check for friend of author of bulletin

if (isset($_SESSION['user'], $_POST['submit'], $_POST['comment']) && !empty($_POST['comment'])) {
    //remove to allow unique usernames
    $authorId = $_SESSION['userId']; 
    $commentText = trim($_POST['comment']);

    if (addBulletinComment($toid, $authorId, $commentText)) {
        header("Location: bulletincomments.php?id=$toid");
        exit;
    } else {
        echo "<p>Error adding comment.</p>";
    }
}

?>

<?php require_once("bulletins-header.php") ?>

<div class="row edit-profile">
  <div class="col w-20 left">
    <!-- Sidebar goes here -->
  </div>
  <div class="col right">
    <h2>Add Comment</h2>
    <p>Be nice.</p>
        <form method="post" class="ctrl-enter-submit">
      <label for="comment"><h4>Your Comment:</h4></label>
      <textarea class="big_textarea" id="comment" name="comment" required autofocus></textarea>
      <button type="submit" name="submit">Add Comment</button>
      <a href="profile.php?id=<?= $toid ?>"><button type="button">Cancel</button></a>
    </form>
  </div>
</div>

<?php require_once("../footer.php") ?>