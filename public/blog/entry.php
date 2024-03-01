<?php
require("../../core/conn.php");
require_once("../../core/settings.php");
require_once("../../core/site/user.php");
require_once("../../core/site/blog.php");
require_once("../../core/site/comment.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
} else {
    $blogEntryId = $_GET['id'];
}

$blogEntry = fetchBlogEntry($blogEntryId);
$authorId = $blogEntry['author'];

$userInfo = fetchUserInfo($authorId);

if (!isset($_SESSION['userId'])) {
    $userId = null;
} else {
    $userId = $_SESSION['userId'];
}

$isUserAuthor = ($userId == $authorId);

// COMMENTS
$toid = $blogEntryId;
$limitedBlogComments = fetchBlogComments($blogEntryId, 20);
$countComments = count($limitedBlogComments);
$countTotalComments = count(fetchBlogComments($blogEntryId));
$commentType = 'blog';
?>
<?php require("blog-header.php"); ?>

<div class="row article blog-entry" itemscope itemtype="http://schema.org/Article">
    <div class="col w-20 left">
    <span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
      <meta itemprop="name" content="<?= SITE_NAME ?>">
      <meta itemprop="logo" content="https://3to.moe/a/corespace.png">
    </span>
        <!-- User Info Box -->
        <div class="edit-info">
            <div class="profile-pic">
                <img class="pfp-fallback" src="../media/pfp/<?= $userInfo['pfp'] ?>"
                    alt="<?= htmlspecialchars($userInfo['username']) ?>'s profile picture" loading="lazy">
            </div>
            <div class="author-details">
                <h4>
                    Published by
                    <span itemprop="author" itemscope itemtype="http://schema.org/Person">
                        <meta itemprop="url" content="../profile.php?id=<?= $blogEntry['author'] ?>">
                        <span itemprop="name">
                            <a href="user.php?id=<?= $blogEntry['author'] ?>">
                                <?= htmlspecialchars($userInfo['username']) ?>
                            </a>
                        </span>
                    </span>
                </h4>
                <p class="publish-date">
                    published <time class="ago" itemprop="datePublished" content="<?= $blogEntry['date'] ?>">
                        <?= time_elapsed_string($blogEntry['date']) ?>
                    </time><br>
                </p>
                <p class="category">
                  <!-- <b>Privacy:</b> <?= htmlspecialchars($blogEntry['privacy']) ?><br> !-->
                  <b>Category:</b> <a href="category.php?id=<?= $blogEntry['category'] ?>"><?= getCategoryName($blogEntry['category']) ?></a>
                </p>
                <p class="links">
                    <a href="user.php?id=<?= $authorId ?>">
                        <img src="../static/icons/script.png" class="icon" aria-hidden="true" loading="lazy" alt=""> <span
                            class="m-hide">View</span> Blog
                    </a>
                    <a href="https://<?= DOMAIN_NAME ?>../profile.php?id=<?= $authorId ?>">
                        <img src="../static/icons/user.png" class="icon" aria-hidden="true" loading="lazy" alt=""> <span
                            class="m-hide">View</span> Profile
                    </a>

            </div>
        </div>
    </div>


    <div class="col right">
        <h1 class="title" itemprop="headline name">
            <?= htmlspecialchars($blogEntry['title']) ?>
        </h1>
        <?php if ($isUserAuthor): ?>
            <p class="links">
                <a href="editpost.php?id=<?= $blogEntry['id'] ?>">[edit]</a> 
                <a href="deletepost.php?id=<?= $blogEntry['id'] ?>">[delete]</a> 
                <a href="#/pin?id=<?= $blogEntry['id'] ?>">[pin to blog]</a>
            </p>
        <?php endif; ?>
        <div class="content" itemprop="articleBody">
            <?= $blogEntry['text'] ?>
        </div>
        
        
        
        
        <!-- Comments Section -->
        <br>
        <div class="comments" id="comments">
            <div class="heading">
                <h4>Comments</h4>
            </div>
            <div class="inner">
                <meta itemprop="commentCount" content="0">
                <p>
                    <b>
                        Displaying <span class="count"><?= $countComments ?></span> of <span class="count"><?= $countTotalComments ?></span> comments
                        ( <a href="comments.php?id=<?= $blogEntry['id'] ?>">View all</a> | <a href="addcomment.php?id=<?= $blogEntry['id'] ?>">Add Comment</a>
                        )
                    </b>
                </p>
                <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff" border="1">
                    <tbody>
                        <?php $comments = $limitedBlogComments ?>
                        <?php include("../../core/components/comments_block.php") ?>
                    </tbody>
                </table>
                <a href="addcomment.php?id=<?= $blogEntry['id'] ?>"><button style="margin: 14px 0;">Add a Comment</button></a>
            </div>
        </div>
    </div>
</div>

<?php require("../footer.php"); ?>