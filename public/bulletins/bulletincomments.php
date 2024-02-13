<?php
require("../../core/conn.php");
require_once("../../core/settings.php");
require("../../core/site/user.php"); 
require("../../core/site/comment.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit; 
}

$toid = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Ensure you validate and sanitize input
$bulletinComments = fetchBulletinComments($toid);

?>

<?php require_once("bulletins-header.php") ?>

<div class="simple-container">
    <h1>Comments</h1>
    <p><a href="bulletin.php?id=<?= $toid ?>">&laquo; Back to Bulletin</a></p>
    <br>
    <?php if (empty($bulletinComments)): ?>
    <p>No comments yet.</p>
    <?php else: ?>
    <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff" border="1">
        <tbody>
            <?php foreach ($bulletinComments as $comment): ?>
            <tr>
                <td>
                    <a href="profile.php?id=<?= htmlspecialchars($comment['author']) ?>">
                        <p><?= htmlspecialchars(fetchName($comment['author'])) ?></p>
                    </a>
                    <a href="profile.php?id=<?= htmlspecialchars($comment['author']) ?>">
                    <?php
                        $pfpPath = fetchPFP($comment['author']);
                        $pfpPath = $pfpPath ? $pfpPath : 'default.png';
                    ?>
                        <img class="pfp-fallback" src="../media/pfp/<?= $pfpPath ?>" alt="<?= htmlspecialchars(fetchName($comment['author'])) ?>'s profile picture" loading="lazy" width="50px">
                    </a>
                </td>
                <td>
                    <p><b><time class=""><?= time_elapsed_string($comment['date']) ?></time></b></p>
                    <p><?= htmlspecialchars($comment['text']) ?></p>
                    <br>
                    <p class="report">
                        <a href="/report?type=comment&id=<?= htmlspecialchars($comment['id']) ?>" rel="nofollow">
                            <img src="/static/icons/flag_red.png" class="icon" aria-hidden="true" loading="lazy" alt=""> Report Comment
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

<?php require_once("../footer.php") ?>