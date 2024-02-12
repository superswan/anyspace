<?php
require("func/conn.php");
require_once("func/settings.php");
require("func/site/user.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<?php require("header.php"); ?>

<div class="simple-container">
    <h1>Browse Users</h1>
    <p>
        Filter:
        <a href="browse" class="filter-active">
            <img src="static/icons/tick.png" class="icon" aria-hidden="true" loading="lazy" alt="">
            All Users
        </a>
        |
        <a href="browse?view=new" class="">
            New People
        </a>
        |
        <a href="browse?view=online" class="">
            Online Users
        </a>
    </p>
    <p>
        Friends:
        <a href="browse?view=active" class="filter-active">
            <img src="static/icons/tick.png" class="icon" aria-hidden="true" loading="lazy" alt="">
            Include Friends
        </a>
        |
        <a href="browse?view=active&friends=no" class="">
            Exclude Friends
        </a>
    </p>
    <div class="new-people cool">
        <div class="top">
            <h4>Active Users</h4>
        </div>
        <div class="inner">
            <?php
            $stmt = $conn->prepare("SELECT id, username, pfp FROM `users`");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $profilePicPath = htmlspecialchars('pfp/' . $row['pfp']);
                $profileLink = 'profile.php?id=' . $row['id'];
                $username = htmlspecialchars($row['username']);

                echo "<div class='person'>";
                echo "<a href='{$profileLink}'><p>{$username}</p></a>";
                echo "<a href='{$profileLink}'><img class='pfp-fallback' src='{$profilePicPath}' alt='Profile Picture' loading='lazy' style='aspect-ratio: 1/1;'>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>

<?php require("footer.php"); ?>