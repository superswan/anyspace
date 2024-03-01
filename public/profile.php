<?php
require("../core/conn.php");
require_once("../core/settings.php");
require("../core/site/user.php");
require("../core/site/comment.php");
require("../core/site/friend.php");
require("../core/site/blog.php");


if(isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
} else {
    $userId = null;
}

// Fetch user information
$userInfo = fetchUserInfo($_GET['id']);
$user = $userInfo ? $userInfo['username'] : '';
$profileId = $userInfo['id'];

$userInterests = $userInfo['interests'];
$interests = json_decode($userInterests, true);

// Fetch blogs and friends using the user's username
$blogs = fetchUserBlogs($conn, $user);

$friends = array_merge(
    fetchFriends($conn, 'ACCEPTED', 'receiver', $profileId),
    fetchFriends($conn, 'ACCEPTED', 'sender', $profileId)
);
$friendsTopEight = fetchUserFriends($profileId, 8);

$isFriend = false;
$isPendingFriend = false;

if ($userId !== null) {
    // Check if users are friends
    $isFriend = checkFriend($userId, $profileId);
    
    if (!$isFriend) {
        // If they are not friends, check for pending friend requests
        $isPendingFriend = checkFriendPending($userId, $profileId);
    }
}

// Fetch comments
$toid = $profileId;
$comments = fetchComments($profileId, 20);
$countComments = count($comments);
$countTotalComments = count(fetchComments($profileId));

$blogEntries = fetchBlogEntries($profileId, 4);
$statusInfo = fetchUserStatus($profileId);

?>

<!DOCTYPE html>
<html>

<head>
    <title><?= $user ?>'s Profile | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="static/css/normalize.css">
    <link rel="stylesheet" href="static/css/base.css"> 
    <link rel="stylesheet" href="static/css/my.css">
<!-- Doesn't seem to work on profile page
        <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden; 
        }

        @media screen and (max-width: 768px) {
            .row.home {
                display: flex;
                flex-direction: column;
            }

            .col {
                width: 100%;
            }

            .col.right {
                width: 60%);
                margin: 0 auto; 
            }

             .col.w-60 {
                width: 100%;
            }

            .master-container {
                width: 100%;
            }
        }
    </style>
    -->
    <style>
    .profile-info {
        height: 82px;
    }

    #music {
        position: fixed;
        bottom: 10px;
        left: 10px;
        width: 80px;
        transition: 0.5s width;
    }

    #music:hover {
        width: 360px;
    }
    </style>
</head>

<body>

<div class="container">
  <nav class="">
    <div class="top">
        <div class="left">
        <a href="index.php">
            <?= SITE_NAME ?>
            </a> | <a href="index.php">Home</a>
        </div>
        <div class="center">

            <form>
                <label for="q">
                    Search <?= htmlspecialchars(SITE_NAME); ?>:
                </label>
                <div class="search-wrapper">
                    <input id="q" type="text" name="q" autocomplete="off">
                </div>
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="right">
            <ul class="topnav signup">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="docs/help.html">Help</a> | <a href="logout.php">LogOut</a>
                <?php else: ?>
                    <a href="docs/help.html">Help</a> |
                    <a href="docs/help.html">LogIn</a> |
                    <a href="register.php">SignUp</a>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <ul class="links">
        <?php
        $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $currentPage = basename($currentUrl);

        $isHomePage = in_array($currentPage, array('index.php', 'home.php'));

        $navItems = array(
            'Home' => 'index.php',
            'Browse' => 'browse.php',
            'Search' => 'search.php',
            'Mail' => 'messages.php',
            'Blog' => 'blog/',
            'Bulletins' => 'bulletins/',
            'Forum' => 'forum.php',
            'Groups' => '#',
            'Layouts' => 'layouts/',
            'Favs' => 'favorites.php',
            'Source' => 'https://github.com/superswan/anyspace',
            'Help' => 'docs/help.html',
            'About' => 'about.php',
          );

        foreach ($navItems as $name => $page) {
            if ($name == 'Home' && $isHomePage) {
                $activeClass = 'class="active"';
            } else {
                $activeClass = ($currentPage == basename($page)) ? 'class="active"' : '';
            }
            echo "<li><a href=\"$page\" $activeClass>&nbsp;$name </a></li>";
        }
        ?>
    </ul>
  </nav>



        <main>
            <!-- USER PROFILE -->
            <div class="row profile" itemscope itemtype="https://schema.org/Person">
                <meta itemprop="url"
                    content="https://<?= htmlspecialchars(DOMAIN_NAME); ?>profile.php?id=<?= htmlspecialchars($profileId); ?>">
                <meta itemprop="identifier" content="<?= htmlspecialchars($user); ?>">
            <!-- LEFT COLUMN -->
                <div class="col w-40 left">
                    <span itemprop="name" style="margin-top: 0;">
                        <?php if ($userInfo): ?>
                            <h1 style='margin: 0px;'>
                                <?= htmlspecialchars($userInfo['username']); ?>
                            </h1>
                        </span>
            <!-- PROFILE PICTURE BOX -->
                        <div class="general-about">
                            <div class="profile-pic">
                                <img class='pfp-fallback' style="width: 235px; height: auto; aspect-ratio: 1/1;" alt="user pfp" src='media/pfp/<?= htmlspecialchars($userInfo['pfp']); ?>'>
                            </div>
                            <div class="details">
                                <?php if (!empty($statusInfo['status'])): ?>
                                        <p>"<?= $statusInfo['status'] ?>"
                                        </p>
                                    <? endif; ?>
                                    <?php if (!empty($statusInfo['you'])): ?>
                                        <p><?= $statusInfo['you'] ?>
                                        </p>
                                    <? endif; ?>
                                    <p class="online"><img src="static/img/green_person.png" aria-hidden="true" alt="Online icon" loading="lazy">
                                        ONLINE!</p>
                                </div>
                            </div>
            <!-- AUDIO -->
                            <audio controls autoplay loop id="music">
                                <source src="media/music/<?= htmlspecialchars($userInfo['music']); ?>" type="audio/ogg">
                        </audio> 
            <!-- MOOD -->

                        <div class="mood">
                            <p>
                                <b>Mood: </b>
                                <?= htmlspecialchars($statusInfo['mood']); ?>
                            </p>
                            <p>
                                <b>View my:
                                    <a href="blog/user.php?id=<?= $userInfo['id'] ?>">Blog</a> 
                                    <?php if ($isFriend || $userId == $profileId): ?>
                                    |
                                    <a href="bulletins/userbulletins.php?id=<?= $userInfo['id'] ?>">Bulletins</a> 
                                    <?php endif; ?>
                                </b>
                            </p>
                        </div>




                        <!-- CONTACT BOX -->
                        <div class="contact">
                            <div class="heading">
                                <h4>Contacting
                                    <?= htmlspecialchars($user); ?>
                                </h4>
                            </div>
                            <div class="inner">
                                <div class="f-row">
                                    <div class="f-col">
                                        <?php if ($isFriend): ?>
                                        <a href="unfriend.php?action=add&id=<?= htmlspecialchars($profileId); ?>"
                                            rel="nofollow">
                                            <img src="static/icons/delete.png" class="icon" aria-hidden="true" loading="lazy"
                                                alt=""> Remove Friend
                                        </a>
                                        <?php elseif ($isPendingFriend): ?>
                                        <a href="requests.php"
                                            rel="nofollow">
                                            <img src="static/icons/hourglass.png" class="icon" aria-hidden="true" loading="lazy"
                                                alt=""> Pending Request
                                        </a>
                                        <?php else: ?>
                                        <a href="friends.php?action=add&id=<?= htmlspecialchars($profileId); ?>"
                                            rel="nofollow">
                                            <img src="static/icons/add.png" class="icon" aria-hidden="true" loading="lazy"
                                                alt=""> Add to Friends
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="f-col">
                                        <a href="addfavorite.php?id=<?= $profileId ?>" rel="nofollow">
                                            <img src="static/icons/award_star_add.png" class="icon" aria-hidden="true"
                                                loading="lazy" alt=""> Add to Favorites
                                        </a>
                                    </div>
                                </div>
                                <div class="f-row">
                                    <div class="f-col">
                                        <a href="#" rel="nofollow">
                                            <img src="static/icons/comment.png" class="icon" aria-hidden="true"
                                                loading="lazy" alt=""> Send Message
                                        </a>
                                    </div>
                                    <div class="f-col">
                                        <a href="#" rel="nofollow">
                                            <img src="static/icons/arrow_right.png" class="icon" aria-hidden="true"
                                                loading="lazy" alt=""> Forward to Friend
                                        </a>
                                    </div>
                                </div>
                                <div class="f-row">
                                    <div class="f-col">
                                        <a href="#" rel="nofollow">
                                            <img src="static/icons/email.png" class="icon" aria-hidden="true" loading="lazy"
                                                alt=""> Instant Message
                                        </a>
                                    </div>
                                    <div class="f-col">
                                        <a href="#" rel="nofollow">
                                            <img src="static/icons/exclamation.png" class="icon" aria-hidden="true"
                                                loading="lazy" alt=""> Block User
                                        </a>
                                    </div>
                                </div>
                                <div class="f-row">
                                    <div class="f-col">
                                        <a href="#">
                                            <img src="static/icons/group_add.png" class="icon" aria-hidden="true"
                                                loading="lazy" alt=""> Add to Group
                                        </a>
                                    </div>
                                    <div class="f-col">
                                        <a href="#" rel="nofollow">
                                            <img src="static/icons/flag_red.png" class="icon" aria-hidden="true"
                                                loading="lazy" alt=""> Report User
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- URL BOX -->
                        <div class="url-info">
                            <p><b>
                                    <?= htmlspecialchars(SITE_NAME); ?> URL:
                                </b></p>
                            <p>https://<?= htmlspecialchars(DOMAIN_NAME); ?>/profile.php?id=<?= htmlspecialchars($profileId); ?></p>
                        </div>





                        <!-- INTERESTS -->
                        <div class="table-section">
                            <div class="heading">
                                <h4>
                                    <?= htmlspecialchars($userInfo['username']); ?>'s Interests
                                </h4>
                            </div>
                            <div class="inner">
                                <table class="details-table" cellspacing="3" cellpadding="3">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <p>General</p>
                                            </td>
                                            <td>
                                                <p>
                                                    <?= htmlspecialchars($interests['General']); ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Music</p>
                                            </td>
                                            <td>
                                                <p>
                                                    <?= htmlspecialchars($interests['Music']); ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Movies</p>
                                            </td>
                                            <td>
                                                <p>
                                                    <?= htmlspecialchars($interests['Movies']); ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Television</p>
                                            </td>
                                            <td>
                                                <p>
                                                    <?= htmlspecialchars($interests['Television']); ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Books</p>
                                            </td>
                                            <td>
                                                <p>
                                                    <?= htmlspecialchars($interests['Books']); ?>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>
                                                    Heroes
                                                </p>
                                            </td>
                                            <td>
                                                <p>
                                                    <?= htmlspecialchars($interests['Heroes']); ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p>User not found.</p>
                        <?php endif; ?>
                    </div>
                </div>




                <!-- RIGHT COLUMN -->
                <div class="col right">

                <!-- UGLY BLOCK -->
                    <?php if($isFriend): ?>
                    <div class="profile-info">
                        <div class="inner">
                            <h3><?= $user . " is your Friend." ?></h3>
                        </div>
                    </div>
                    <?php elseif ($userId == $profileId): ?>
                    <div class="profile-info">
                        <div class="inner">
                            <h3><a href="manage.php">Edit Your Profile</a></h3>
                        </div>
                    </div>
                    <?php endif; ?>



                <!-- BLOG -->
                    <div class="blog-preview">
                        <h4>
                            <?= htmlspecialchars($userInfo['username']); ?>'s Latest Blog Entries [<a href="blog/user.php?id=<?= $userInfo['id'] ?>">View
                                Blog</a>]
                        </h4>
                        <?php if (empty($blogEntries)): ?>
                                    <p><i>There are no Blog Entries yet.</i></p>
                                <?php else: ?>
                                    <?php foreach ($blogEntries as $entry): ?>
                                        <?php
                                        $maxTitleLength = 25;
                                        $title = $entry['title'];
                                        if (mb_strlen($title) > $maxTitleLength) {
                                            $title = mb_substr($title, 0, $maxTitleLength) . '...';
                                        }
                                        ?>
                                        <p>
                                            <?= htmlspecialchars($title) ?> 
                                            (<a href="blog/entry.php?id=<?= $entry['id'] ?>">View More</a>)
                                        </p>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                    </div>




                    <!-- BLURBS -->
                    <div class="blurbs">
                        <div class="heading">
                            <h4>
                                <?= htmlspecialchars($userInfo['username']); ?>'s Bio
                            </h4>
                        </div>
                        <div class="inner">
                            <div class="section">
                                <p itemprop="description">
                                    <?= $userInfo['bio']; ?>
                                    
                                    
                                    <!-- USER STYLES -->
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = :id");
                                    $stmt->execute(array(':id' => $_GET['id']));

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo $row['css'];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>



                    <!-- TOP 8 FRIENDS -->
                    <div class="friends">
                        <div class="heading">
                            <h4>
                                <?= htmlspecialchars($userInfo['username']); ?>'s Friend Space
                            </h4>
                            <a class="more" href="friends.php?id=<?= $profileId ?>">[view all]</a>
                        </div>
                        <div class="inner">
                            <p><b>
                                    <?= htmlspecialchars($userInfo['username']); ?> has <span class="count">
                                        <?= htmlspecialchars(count($friends)); ?>
                                    </span> friends.
                                </b></p>
                            <div class="friends-grid">
                                <?php
                                foreach ($friendsTopEight as $friend) {
                                    $friendId = $profileId === $friend['sender'] ? $friend['receiver'] : $friend['sender'];

                                    if ($friendId == $profileId) {
                                        continue;
                                    }
                                    printPerson($friendId);
                                }
                                ?>
                            </div>
                        </div>
                    </div>




                    <!-- COMMENTS -->
                    <div class="friends" id="comments">
                        <div class="heading">
                            <h4>
                                <?= htmlspecialchars($userInfo['username']); ?>'s Friends Comments
                            </h4>
                        </div>
                        <div class="inner">
                            <p>
                                <b>
                                    Displaying <span class="count"><?= $countComments ?></span> of <span class="count"><?= $countTotalComments ?></span> comments
                                    ( <a href="comments.php?id=<?= $userInfo['id'] ?>">View all</a> | <a
                                        href="addcomment.php?id=<?= $userInfo['id'] ?>">Add
                                        Comment</a> )
                                </b>
                            </p>
                            <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff"
                                border="1">
                                <tbody>
                                    <?php include("../core/components/comments_block.php") ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </main>
        <footer>
        <p>
                <a href="https://github.com/superswan/anyspace/superswan/anyspace" target="_blank" rel="noopener">AnySpace Engine</a>
        </p>
        <p> <i>Disclaimer: This project is not affiliated with MySpace&reg; in any way.</i>
        </p>
        <ul class="links">
                <li><a href="about.php">About</a></li>
                <li><a href="rules.php">Rules</a></li>
                <li><a href="/docs/help.html">Help</a></li>
                <li><a href="https://github.com/superswan/anyspace/superswan/anyspace">Source Code</a></li>
        </ul>
        <p class="copyright">
                <a href="https://github.com/superswan/anyspace/superswan/anyspace/superswan/anyspace">&copy;2024 Copyleft</a>
        </p>
</footer>
</div>

</body>

</html>