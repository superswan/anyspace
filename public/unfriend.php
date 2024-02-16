<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/friend.php");
require_once("../core/site/user.php");

login_check();

$userId = $_SESSION['userId'];
$friendId = isset($_GET['id']) ? $_GET['id'] : null;

if (!$friendId) {
    header("Location: index.php");
    exit;
}

$isFriend = checkFriend($userId, $friendId);

if (!$isFriend) {
    header("Location: index.php");
    exit;
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $confirmation = isset($_POST['confirmation']) ? strtoupper(trim($_POST['confirmation'])) : '';
    if ($confirmation == 'DELETE') {
        removeFriend($userId, $friendId);
        header("Location: friends.php");
        exit;
    }
}
?>
<?php require("header.php"); ?>

<div class="simple-container">
    <h1>Are you sure you want to unfriend <?= fetchName($friendId); ?>?</h1>
    <form method="POST" action="">
        <p>Type "DELETE" to remove friend:</p>
        <input type="text" name="confirmation" required>
        <button type="submit" name="submit">Delete</button>
        <button onclick="location.href='/friends/index.php'; return false;" type="button" name="cancel">Cancel</button>
    </form>
</div>
<?php require("footer.php"); ?>

</body>
</html>
