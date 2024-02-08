<?php
require_once("func/conn.php");
require_once("func/settings.php");
require("func/site/user.php"); 
require("func/site/comment.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit; 
}

$toid = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Ensure you validate and sanitize input
$comments = fetchComments($conn, $toid);

?>

<?php require_once("header.php") ?>

<div class="simple-container">
    <h1><?= getName($toid, $conn) ?>'s Friends Comments</h1>
    <p><a href="profile.php?id=1">&laquo; Back to <?= getName($toid, $conn) ?>'s Profile</a></p>
    <br>
    <?php if (empty($comments)): ?>
    <p>No comments yet.</p>
    <?php else: ?>
    <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff" border="1">
        <tbody>
            <?php foreach ($comments as $comment): ?>
            <tr>
                <td>
                    <a href="profile.php?id=<?= htmlspecialchars($comment['author']) ?>">
                        <p><?= htmlspecialchars(getName($comment['author'], $conn)) ?></p>
                    </a>
                    <a href="profile.php?id=<?= htmlspecialchars($comment['author']) ?>">
                    <?php
                        $pfpPath = getPFP(getName($comment['author'], $conn), $conn);
                        $pfpPath = $pfpPath ? $pfpPath : 'default.png';
                    ?>
                        <img class="pfp-fallback" src="pfp/<?= $pfpPath ?>" alt="<?= htmlspecialchars(getName($comment['author'], $conn)) ?>'s profile picture" loading="lazy" width="50px">
                    </a>
                </td>
                <td>
                    <p><b><time class=""><?= htmlspecialchars($comment['date']) ?></time></b></p>
                    <p><?= htmlspecialchars($comment['text']) ?></p>
                    <br>
                    <p class="report">
                        <a href="/report?type=comment&id=<?= htmlspecialchars($comment['id']) ?>" rel="nofollow">
                            <img src="https://static.spacehey.net/icons/flag_red.png" class="icon" aria-hidden="true" loading="lazy" alt=""> Report Comment
                        </a>
                    </p>
                    <a href="/addcomment?id=<?= $toid ?>&reply=<?= htmlspecialchars($comment['id']) ?>">
                        <button>Add Reply</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?php require_once("footer.php") ?>