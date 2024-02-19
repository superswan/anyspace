<?php
require("../core/conn.php");
require_once("../core/settings.php");
require("../core/site/user.php");

$view = isset($_GET['view']) ? $_GET['view'] : '';

function isFilterActive($filter, $friends = null) {
    $currentView = isset($_GET['view']) ? $_GET['view'] : '';
    $currentFriends = isset($_GET['friends']) ? $_GET['friends'] : null;

    if ($currentView === $filter && $friends === null) {
        return true; // Filter is active without considering friends
    }

    if ($currentView === $filter && $currentFriends === $friends) {
        return true; // Filter is active considering friends
    }

    if ($currentView === 'new' && $friends === '') {
        return true; 
    }

    return false;
}

?>

<?php require("header.php"); ?>

<div class="simple-container">
    <h1>Browse Users</h1>
    <p>
    Filter:
    <a href="browse.php" class="<?= isFilterActive('') ? 'filter-active' : '' ?>">
    <?php if (isFilterActive('')): ?>
        <img src="static/icons/tick.png" class="icon" aria-hidden="true" loading="lazy" alt="">
    <?php endif; ?>
    All Users
</a>
|
<a href="browse.php?view=new" class="<?= isFilterActive('new') ? 'filter-active' : '' ?>">
    <?php if (isFilterActive('new')): ?>
        <img src="static/icons/tick.png" class="icon" aria-hidden="true" loading="lazy" alt="">
    <?php endif; ?>
    New People
</a>
<!--
<p>
    Friends:
    <a href="browse.php?view=active" class="<?= isFilterActive('') ? 'filter-active' : '' ?>">
        <?php if (!isset($_GET['friends'])): ?>
            <img src="static/icons/tick.png" class="icon" aria-hidden="true" loading="lazy" alt="">
        <?php endif; ?>
        Include Friends
    </a>
    |
    <a href="browse.php?view=active&friends=no" class="<?= isFilterActive('active', 'no') ? 'filter-active' : '' ?>">
        <?php if (isFilterActive('active', 'no')): ?>
            <img src="static/icons/tick.png" class="icon" aria-hidden="true" loading="lazy" alt="">
        <?php endif; ?>
        Exclude Friends
    </a>
</p>
        -->
    <div class="new-people">
        <div class="top">
            <h4>Active Users</h4>
            <a class="more" href="#">[random]</a>
        </div>
        <div class="inner">
            <?php
            if ($view === 'new') {
                $query = "SELECT id, username, pfp FROM `users` ORDER BY id DESC";
            } else if ($view === 'online') { 
                $query = "SELECT id, username, pfp FROM `users` WHERE online_status = 'Online'";
            } else {
                $query = "SELECT id, username, pfp FROM `users`";
            }

            $stmt = $conn->prepare($query);
            $stmt->execute();

            // Fetch and display each row
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                printPerson($row['id']);
            }
            ?>
        </div>
    </div>
</div>

<?php require("footer.php"); ?>