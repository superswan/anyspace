<?php
require("func/conn.php");
require_once("func/settings.php");
require("func/site/user.php");
require("func/site/comment.php");
require("func/site/friend.php");

// Fetch user information
$userInfo = fetchUserInfo($conn, $_GET['id']);
$user = $userInfo ? $userInfo['username'] : '';
$userId = $userInfo['id'];

// Fetch blogs and friends using the user's username
$blogs = fetchUserBlogs($conn, $user);
$friends = fetchUserFriends($conn, $user);

// Fetch comments
$comments = fetchComments($conn, $_GET['id']);

// Fetch users for the users list
$users = fetchUsers($conn);

$userInterests = $userInfo['interests'];

$interests = json_decode($userInterests, true);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link rel="stylesheet" href="static/css/my.css">

    <!-- USER STYLES -->
    <?php
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = :id");
    $stmt->execute(array(':id' => $_GET['id']));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<style>" . $row['css'] . "</style>";
    }
    ?>
</head>

<body>
    <div class="master-container">
        <?php
        require("navbar.php");
        ?>
        <main>
            <div class="row profile" itemscope itemtype="https://schema.org/Person">
                <meta itemprop="url"
                    content="https://<?= htmlspecialchars(DOMAIN_NAME); ?>/profile?id=<?= htmlspecialchars($userInfo['username']); ?>">
                <meta itemprop="identifier" content="<?= htmlspecialchars($userInfo['username']); ?>">
                <div class="col w-40 left">
                    <span itemprop="name">
                        <?php if ($userInfo): ?>
                            <br><br>
                            <h1 style='margin: 0px;'>
                                <?= htmlspecialchars($userInfo['username']); ?>
                            </h1>
                        </span>
                        <div class="general-about">
                            <div class="profile-pic">
                                <img class='pfp-fallback' width='235px;'
                                    src='pfp/<?= htmlspecialchars($userInfo['pfp']); ?>'>
                            </div>
                            <div class="details">
                                <p class="online"><img src="static/img/green_person.png"
                                        aria-hidden="true" alt="Online icon" loading="lazy"> ONLINE!</p>
                            </div>
                        </div>
                        <audio controls autoplay>
                            <source src="music/<?= htmlspecialchars($userInfo['music']); ?>" type="audio/ogg">
                        </audio>
                        <div class="mood">
                            <p>
                                <b>Mood: </b>
                                <?= htmlspecialchars($userInfo['status']); ?>
                            </p>
                            <p>
                                <b>View my:
                                    <a href="#">Blog</a>
                                </b>
                            </p>
                        </div>
                        <div class="contact">
                            <div class="heading">
                                <h4>Contacting
                                    <?= htmlspecialchars($userInfo['username']); ?>
                                </h4>
                            </div>
                            <div class="inner">
                                <div class="f-row">
                                    <div class="f-col">
                                        <a href="friends.php?action=add&id=<?= htmlspecialchars($userInfo['id']); ?>"
                                            rel="nofollow">
                                            <img src="static/icons/add.png" class="icon" aria-hidden="true" loading="lazy"
                                                alt=""> Add to Friends
                                        </a>
                                    </div>
                                    <div class="f-col">
                                        <a href="#" rel="nofollow">
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
                        <div class="url-info">
                            <p><b>
                                    <?= htmlspecialchars(SITE_NAME); ?> URL:
                                </b></p>
                            <p>
                                https://<?= htmlspecialchars(DOMAIN_NAME); ?>/profile?id=<?= htmlspecialchars($userInfo['id']); ?>
                            </p>
                        </div>
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
                <div class="col right">
                    <div class="blog-preview">
                        <h4>
                            <?= htmlspecialchars($userInfo['username']); ?>'s Latest Blog Entries [<a href="#">View
                                Blog</a>]
                        </h4>
                        <p><i>There are no Blog Entries yet.</i></p>
                    </div>
                    <div class="blurbs">
                        <div class="heading">
                            <h4>
                                <?= htmlspecialchars($userInfo['username']); ?>'s Bio
                            </h4>
                        </div>
                        <div class="inner">
                            <div class="section">
                                <p itemprop="description">
                                    <?= htmlspecialchars($userInfo['bio']); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="friends">
                        <div class="heading">
                            <h4>
                                <?= htmlspecialchars($userInfo['username']); ?>'s Friend Space
                            </h4>
                            <a class="more" href="#">[view all]</a>
                        </div>
                        <div class="inner">
                            <p><b>
                                    <?= htmlspecialchars($userInfo['username']); ?> has <span class="count">
                                        <?= htmlspecialchars(count($friends)); ?>
                                    </span> friends.
                                </b></p>
                            <div class="friends-grid">

                            </div>
                        </div>
                    </div>
                    <div class="friends" id="comments">
                        <div class="heading">
                            <h4>
                                <?= htmlspecialchars($userInfo['username']); ?>'s Friends Comments
                            </h4>
                        </div>
                        <div class="inner">
                            <p>
                                <b>
                                    Displaying <span class="count">0</span> of <span class="count">0</span> comments
                                    ( <a href="#">View all</a> | <a href="comments.php">Add
                                        Comment</a> )
                                </b>
                            </p>
                            <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff"
                                border="1">
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </main>
</body>

</html>