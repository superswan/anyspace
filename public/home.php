<?php
require_once("../core/conn.php");
require_once("../core/settings.php");
require("../core/site/user.php");
require("../core/site/friend.php");
require("../core/site/comment.php");
require("../core/site/blog.php");
require("../core/site/bulletin.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Fetch user information
$userInfo = fetchUserInfo($_SESSION['userId']);
$user = $userInfo ? $userInfo['username'] : '';
$userId = $userInfo['id'];

// Fetch blogs and friends using the user's username
$blogs = fetchUserBlogs($conn, $user);

// Fetch users for the users list
$users = fetchUsers($conn);

// FRIENDS
$pendingRequests = fetchFriends($conn, 'PENDING', 'receiver', $userId);

$friends = array_merge(
    fetchFriends($conn, 'ACCEPTED', 'receiver', $userId),
    fetchFriends($conn, 'ACCEPTED', 'sender', $userId)
);

$friendCount = count($friends);


$dateJoined = new DateTime($userInfo['date']);
$formattedDate = $dateJoined->format('M j, Y'); // Formats the date as "Feb 6, 2024"

$sinceJoined = time_elapsed_string($userInfo['date']);

$profileViews = 0;

// Blogs & Bulletins
$blogEntries = fetchBlogEntries($userId, 5);
$bulletins = fetchAllFriendBulletins($userId, 5);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Home | <?= SITE_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/normalize.css">
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link rel="stylesheet" href="static/css/my.css">

</head>

<body>
    <div class="master-container">
        <?php
        require("navbar.php");
        ?>
        <main>
            <!-- Profile Box -->
            <div class="row profile user-home">
                <div class="col w-40 left">
                    <div class="general-about home-actions">
                        <div class="heading">
                            <h1 style='margin: 0px;'>Hello,
                                <?= htmlspecialchars($userInfo['username']); ?>!
                            </h1>
                        </div>
                        <div class="inner">
                            <br>
                            <div class="profile-pic">

                                <img width='235px;' src='media/pfp/<?= htmlspecialchars($userInfo['pfp']); ?>'>
                            </div>
                            <div class="details">
                                <p><a href="manage.php">Edit Profile</a></p>
                                <p><a href="editstatus.php">Edit Status</a></p>
                            </div>
                            <div class="more-options">
                                <p>View My: <a href='profile.php?id=<?= $userId ?>'>Profile</a> | <a
                                        <a href='blog/user.php?id=<?= $userId ?>'>Blog</a> | <a
                                        <a href='bulletins/userbulletins.php?id=<?= $userId ?>'>Bulletins</a> | <a
                                        href='friends.php?id=<?= $userId ?>'>Friends</a> | <a
                                        href='requests.php?id=<?= $userId ?>'>Requests</a>
                                </p>
                                <p>My URL: <a href='profile.php?id=<?= $userId ?>'>https://<?= DOMAIN_NAME ?>/profile.php?id=<?= $userId ?>
                                    </a></p>
                            </div>
                        </div>
                    </div>
                    <div class="url-info view-full-profile">
                        <p><a href="profile.php?id=<?= htmlspecialchars($userInfo['id']) ?>"><b>View Your
                                    Profile</b></p>
                    </div>


                    <!-- sidebar -->
                    <div class="indie-box">
                        <p>
                            <?= htmlspecialchars(SITE_NAME); ?> is an open source social network. Check out the code and
                            host your own instance!
                        </p>
                        <p>
                            <a href="https://github.com" class="more-details">[more details]</a>
                        </p>
                    </div>
                    <div class="specials">
                        <div class="heading">
                            <h4>
                                <?= htmlspecialchars(SITE_NAME); ?> Announcements
                            </h4>
                        </div>
                        <div class="inner">
                            <div class="image">
                                <a href="https://store.remilia.org/">
                                    <img src="https://store.remilia.org/cdn/shop/files/2_1_180x.gif"
                                        alt="Merchandise Photo" loading="lazy">
                                </a>
                            </div>
                            <div class="details" lang="en">
                                <h4><a href="https://store.remilia.org/">REMILIA Merchandise</a></h4>
                                <p><i>Now available!</i> Support REMILIA by buying a high-quality Shirt, Hoodie,
                                    or hat! <span class="m-hide">Check out the full Collection on <a
                                            href="https://store.remilia.org">store.remilia.org</a>!</span></p>
                                <p><b>&raquo; <a href="https://store.remilia.org/">Shop Now!</a></b></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Stats & Blog -->
                <div class="col right">
                    <div class="row top-row">
                        <div class="row top-row">
                            <div class="blog-preview col">
                                <h4>Your Latest Blog Entries [<a href="blog/newpost.php">New Entry</a>]
                                </h4>
                                <?php if (empty($blogEntries)): ?>
                                    <p><i>There are no Blog Entries yet.</i></p>
                                <?php else: ?>
                                    <?php foreach ($blogEntries as $entry): ?>
                                        <?php
                                        $maxTitleLength = 20;
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
                            <div class="statistics col">
                                <div class="heading">
                                    <h4>
                                        <?= htmlspecialchars($userInfo['username']) ?>'s Statistics
                                    </h4><br>
                                    <h4>
                                        <?= htmlspecialchars($formattedDate) ?>
                                    </h4>
                                </div>
                                <div class="inner">
                                    <div class="m-row">
                                        <div class="m-col">
                                            <p>Your Friends: <br> <a
                                                    href="/friends.php?id=<?= htmlspecialchars($userId) ?>"><span
                                                        class="count">
                                                        <?= $friendCount ?>
                                                    </span></a></p>
                                        </div>
                                        <div class="m-col">
                                            <p>Profile Views: <br> <span class="count">
                                                    <?= $profileViews ?>
                                                </span></p>
                                        </div>
                                        <div class="m-col">
                                            <p>Joined: <br> <span class="count"><i>
                                                        <?= $sinceJoined ?>
                                                    </i> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- NEW PEOPLE -->
                    <div class="new-people cool">
                        <div class="top">
                            <h4>Cool New People</h4>

                        </div>
                        <div class="inner">
                            <?php
                            $stmt = $conn->prepare("SELECT id, username, pfp FROM `users` ORDER BY date DESC LIMIT 4");
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $profilePicPath = htmlspecialchars('media/pfp/' . $row['pfp']);
                                $profileLink = 'profile.php?id=' . $row['id'];
                                $username = htmlspecialchars($row['username']);

                                echo "<div class='person'>";
                                echo "<a href='{$profileLink}'><p>{$username}</p></a>";
                                echo "<a href='{$profileLink}'><img class='pfp-fallback' src='{$profilePicPath}' alt='Profile Picture' loading='lazy' style='aspect-ratio: 1/1;'></a>";
                                echo "</div>";
                            }
                            ?>
                        </div>
                        <div class="view-more d-hide">
                            <a href="/browse?view=new">
                                <p>[view more]</p>
                            </a>
                        </div>
                    </div>


                    <!-- BULLETINS -->
                    <div class="bulletin-preview">
                        <div class="heading">
                            <h4>Your Friend's Bulletins</h4>
                            <a class="more" href="/bulletins/">[view all]</a>
                        </div>
                        <?php if (!empty($bulletins)): ?>
                        <table class="bulletin-table preview">
                            <thead>
                                <tr>
                                    <th scope="col">From</th>
                                    <th scope="col">Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bulletins as $entry): ?>
                                <tr>
                                    <td class="user-info">
                                        <a href="profile.php?id=<?= $entry['author'] ?>">
                                        <p><?= fetchName($entry['author']) ?></p>
                                        </a>
                                    </td>
                                    <td class="subject">
                                        <a href="/bulletins/bulletin.php?id=<?= $entry['id'] ?>">
                                        <p><b><?= $entry['title'] ?></b></p>
                                        </a>
                                    </td>
                                </tr>
                                 <?php endforeach; ?>
                                <tr>
                                <td colspan="2">
                                <i><a href="/bulletins/">View all Bulletins</a></i>            </td>
                            </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>


                    <!-- FRIENDS -->
                    <div class="friends">
                        <div class="heading">
                            <h4>Friend Requests</h4>
                        </div>
                        <div class="inner">
                            <p><b><span class="count">
                                        <?= htmlspecialchars(count($pendingRequests)); ?>
                                    </span> Open Friend Requests</b></p>
                            <a href="requests.php">
                                <button>View All Requests</button>
                            </a>
                            <br>
                            <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff"
                                border="1">
                                <tbody>
                                    <?php foreach ($pendingRequests as $request): ?>
                                        <tr>
                                            <td>
                                                <a href="profile.php?id=<?= $request['sender'] ?>">
                                                    <p>
                                                        <?= htmlspecialchars(fetchName($request['sender'])) ?>
                                                    </p>
                                                </a>
                                                <a href="profile.php?id=<?= $request['sender'] ?>">
                                                    <img class="pfp-fallback"
                                                        src="media/pfp/<?= fetchPFP($request['sender']) ?: 'default.png' ?>"
                                                        alt="profile picture" loading="lazy" width="50px">
                                                </a>
                                            </td>
                                            <td>
                                                <p><b>Friend Request</b></p>
                                                <form method="post">
                                                    <input type="hidden" name="type" value="friend-request">
                                                    <input type="hidden" name="request_id"
                                                        value="<?= htmlspecialchars($request['id']) ?>">
                                                    <button
                                                        onclick="location.href='friends.php?action=accept&id=<?= $request['sender'] ?>'"
                                                        name="decision" value="accept" type="button">Accept</button>
                                                    <button
                                                        onclick="location.href='friends.php?action=revoke&id=<?= $request['sender'] ?>'"
                                                        type="button" name="decision" value="decline">Decline</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once("footer.php") ?>