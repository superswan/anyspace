<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/user.php");
require_once("../core/site/blog.php");

login_check();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
} else {
    $authorId = $_GET['id'];
}

$userId = $_SESSION['userId'];

$blogEntries = fetchBlogEntries($authorId, $limit = null);
$userInfo = fetchUserInfo($authorId);
$statusInfo = fetchUserStatus($authorId);
$isUserAuthor = ($userId == $authorId);

?>
<?php require("blog-header.php"); ?>

<div class="row profile">
    <div class="col w-30 left">
        <h1>
            <?= $userInfo['username'] ?>
        </h1>
        <div class="general-about">
            <div class="profile-pic ">
                <img class="pfp-fallback" src="/pfp/<?= $userInfo['pfp'] ?>" alt="twinkars's profile picture"
                    loading="lazy">
            </div>
            <div class="details below">
                <?php if (!empty($statusInfo['status'])): ?>
                    <p>"<?= $statusInfo['status'] ?>"
                    </p>
                <? endif; ?>
                <?php if (!empty($statusInfo['you'])): ?>
                    <p><?= $statusInfo['you'] ?>
                    </p>
                <? endif; ?>
                <p class="online"><img src="../static/img/green_person.png" aria-hidden="true" alt="Online icon"
                        loading="lazy"> ONLINE!</p>
            </div>
        </div>
        <div class="mood">
            <p><b>Mood:</b> <?= $statusInfo['mood'] ?></p><br>
            <p>
                <b>View my:
                    <a href="https://<?= DOMAIN_NAME ?>/profile.php?id=<?= $authorId ?>">Profile</a>
                </b>
            </p>
        </div>

        <div class="url-info">
            <p><b>
                    <?= SITE_NAME ?> Blog URL:
                </b></p>
            <p>https://<?= DOMAIN_NAME ?>/blog/user.php?id=<?= $authorId ?>
            </p>
        </div>
        <div class="url-info view-full-profile">
            <p>
                <a href="https://<?= DOMAIN_NAME ?>/profile.php?id=<?= $authorId ?>">
                    <b>View Full Profile</b>
                </a>
            </p>
        </div>
    </div>
    <div class="col right">
        <div class="blog-preview">
            <h1>
                <?= htmlspecialchars($userInfo['username']) ?>'s Blog Entries
            </h1>
            <?php if ($isUserAuthor): ?>
            <h2>
                [<a href="newpost.php">Create a new Entry</a>]
                </h2>
            <?php endif; ?>
                <br>
            <div class="blog-entries">
                <?php foreach ($blogEntries as $entry): ?>
                    <div class="entry">
                        <p class="publish-date">
                            <time class="ago">
                                <?= time_elapsed_string($entry['date']) ?>
                            </time>
                            </a>
                        </p>
                        <div class="inner">
                            <h3 class="title">
                                <a href="/entry?id=<?= htmlspecialchars($entry['id']) ?>">
                                    <?= htmlspecialchars($entry['title']) ?>
                                </a>
                            </h3>
                            <p>
                                <?php
                                $maxLength = 240;
                                $previewText = $entry['text'];
                                if (mb_strlen($previewText) > $maxLength) {
                                    $previewText = mb_substr($previewText, 0, $maxLength) . '...';
                                }
                                echo $previewText; ?>
                                <a href="entry.php?id=<?= htmlspecialchars($entry['id']) ?>">&raquo; Continue Reading</a>
                            </p>
                            <br>
                            <p>
                                <a href="entry.php?id=<?= htmlspecialchars($entry['id']) ?>">&raquo; View Blog Entry</a>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($blogEntries)): ?>
                    <p>No blog entries found.</p>
                <?php endif; ?>
            </div>
            <div class="pagination">
                <!-- Pagination logic here -->
            </div>
        </div>
    </div>

</div>
</div>

<?php require("../footer.php"); ?>