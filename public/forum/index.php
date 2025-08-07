<?php
require("../../core/conn.php");
require_once("../../core/settings.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$pageCSS = "../static/css/forum.css";
?>
<?php require("../header.php"); ?>

<div class="simple-container">
    <h1>Forums</h1>
    <?php
    $threads = [
        ['status' => 'new', 'title' => 'Welcome to the forums', 'posts' => 3, 'last' => 'Aug 7 by Admin'],
        ['status' => 'locked', 'title' => 'Read the rules before posting', 'posts' => 1, 'last' => 'Aug 6 by Admin'],
        ['status' => 'new', 'title' => 'Introduce Yourself', 'posts' => 5, 'last' => 'Aug 5 by User1'],
    ];
    ?>
    <table class="forum-table">
        <tr>
            <th></th>
            <th>Thread</th>
            <th>Posts</th>
            <th>Last Post</th>
        </tr>
        <?php foreach ($threads as $i => $t): ?>
        <tr<?php if ($i % 2 === 1) echo ' class="forum-row-alt"'; ?>>
            <td>
                <?php if ($t['status'] === 'locked'): ?>
                    <img src="../static/icons/locked.gif" alt="Locked">
                <?php else: ?>
                    <img src="../static/icons/new-post.gif" alt="New Post">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($t['title']) ?></td>
            <td><?= $t['posts'] ?></td>
            <td><?= htmlspecialchars($t['last']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require("../footer.php"); ?>
