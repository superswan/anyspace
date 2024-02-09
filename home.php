<?php
require("func/conn.php");
require_once("func/settings.php");
require("func/site/user.php");
require("func/site/friend.php");
require("func/site/comment.php");

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
    $stmt->execute(array(':id' => $_SESSION['user']));

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

                                <img width='235px;' src='pfp/<?= htmlspecialchars($userInfo['pfp']); ?>'>
                            </div>
                            <div class="details">
                                <p><a href="manage.php">Edit Profile</a>
                            </div>
                            <div class="more-options"></div>
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

                <div class="col right">
                    <div class="row top-row">
                        <div class="row top-row">
                            <div class="blog-preview col">
                                <h4>Your Latest Blog Entries [<a href="#">New Entry</a>]
                                </h4>
                                <p><i>There are no Blog Entries yet.</i></p>
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
                                            <p>Joined: </p> <i>
                                                <?= $sinceJoined ?>
                                            </i> ago
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="new-people cool">
                        <div class="top">
                            <h4>New Users</h4>

                        </div>
                        <div class="inner">
                            <?php
                            $stmt = $conn->prepare("SELECT id, username, pfp FROM `users`");
                            $stmt->execute();

                            // Fetch and display each row
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $profilePicPath = htmlspecialchars('pfp/' . $row['pfp']);
                                $profileLink = 'profile.php?id=' . $row['id'];
                                $username = htmlspecialchars($row['username']);

                                // Display link with profile picture and username
                                echo "<div class='person'>";
                                echo "<a href='{$profileLink}'><p>{$username}</p></a>";
                                echo "<a href='{$profileLink}'><img class='pfp-fallback' src='{$profilePicPath}' alt='Profile Picture' loading='lazy' style='aspect-ratio: 1/1;'>";
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
                    <div class="bulletin-preview">
                        <div class="heading">
                            <h4>Your Friend's Bulletins</h4>
                            <a class="more" href="/bulletins">[view all]</a>
                        </div>
                        <table class="bulletin-table preview">
                        </table>
                    </div>

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
                                                        <?= htmlspecialchars(getName($request['sender'], $conn)) ?>
                                                    </p>
                                                </a>
                                                <a href="profile.php?id=<?= $request['sender'] ?>">
                                                    <img class="pfp-fallback"
                                                        src="pfp/<?= fetchPFP($request['sender']) ?: 'default.png' ?>"
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