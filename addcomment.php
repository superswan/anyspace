<?php
require_once("func/conn.php");
require_once("func/settings.php");
require("func/site/user.php"); 
require("func/site/comment.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit; 
}

$toid = isset($_GET['id']) ? (int)$_GET['id'] : 0; 

if (isset($_SESSION['user'], $_POST['submit'], $_POST['comment']) && !empty($_POST['comment'])) {
    //remove to allow unique usernames
    $authorId = $_SESSION['userId']; 
    $commentText = trim($_POST['comment']);

    if (addComment($toid, $authorId, $commentText)) {
        header("Location: comments.php?id=$toid");
        exit;
    } else {
        echo "<p>Error adding comment.</p>";
    }
}

?>

<?php require_once("header.php") ?>

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

<?php require_once("footer.php") ?>