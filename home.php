<?php
require("func/conn.php");
require_once("func/settings.php");
require("func/site/user.php");
require("func/site/friend.php");
require("func/site/comment.php");

if (!isset($_SESSION['user'])) {
    // Optionally redirect to login page
    header("Location: login.php");
    exit;
}

// Fetch user information
$userInfo = fetchUserInfoByUsername($conn, $_SESSION['user']);
$user = $userInfo ? $userInfo['username'] : ''; 
$userId = $userInfo['id'];

// Fetch blogs and friends using the user's username
$blogs = fetchUserBlogs($conn, $user);
$friends = fetchUserFriends($conn, $user);

// Fetch comments
$comments = fetchComments($conn, $_SESSION['user']);

// Fetch users for the users list
$users = fetchUsers($conn);

// Friend counter
$stmt = $conn->prepare("SELECT COUNT(*) FROM friends WHERE (receiver = :id OR sender = :id) AND status = 'ACCEPTED'");
$stmt->execute(array(':id' => $userId));
$friendCount = $stmt->fetchColumn();

$dateJoined = new DateTime($userInfo['date']);
$formattedDate = $dateJoined->format('M j, Y'); // Formats the date as "Feb 6, 2024"
$now = new DateTime();
$sinceJoined = $dateJoined->diff($now)->format('%y years, %m months, %d days');

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
                                <p><a href="/myspace/manage.php">Edit Profile</a>
                            </div>
                            <div class="more-options"></div>
                        </div>
                    </div>
                    <div class="url-info view-full-profile">
                        <p><a href="/myspace/profile.php?id=<?= htmlspecialchars($userInfo['id']) ?>"><b>View Your
                                    Profile</b></p>
                    </div>
                    <!-- sidebar -->
                    <div class="indie-box">
                        <p>
                            <?= htmlspecialchars(SITE_NAME); ?> is an open source social network. Check out the code and host your own instance!
                        </p>
                        <p>
                            <a href="https://github.com" class="more-details">[more details]</a>
                        </p>
                    </div>
                    <div class="specials">
                        <div class="heading">
                            <h4><?= htmlspecialchars(SITE_NAME); ?> Announcements</h4>
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
                                    </h4><br><h4><?= htmlspecialchars($formattedDate) ?></h4>
                                </div>
                                <div class="inner">
                                    <div class="m-row">
                                        <div class="m-col">
                                            <p>Your Friends: <br> <a
                                                    href="/friends?id=<?= htmlspecialchars($userId) ?>"><span
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
                                            <p>Joined: </p> <i><?= $sinceJoined ?></i> ago
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
                            <p><b><span class="count">0</span> Open Friend Requests</b></p>
                            <a href="friends.php">
                                <button>View All Requests</button>
                            </a>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

<?php require_once("footer.php") ?>