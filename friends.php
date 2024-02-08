<?php
require("func/conn.php"); 
require_once("func/settings.php");
require("func/site/friend.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit;
}

// Page is used as a single entry point for friends actions
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;



if (!empty($action)) {
    if (!$id) {
        exit('Invalid ID.');
    }
    switch ($action) {
        case 'accept':
            acceptFriend($id);
            break;
        case 'add':
            addFriend($id);
            break;
        case 'revoke':
            revokeFriend($id);
            break;
        case 'remove':
            removeFriend($id);
            break;
        default:
            exit('Invalid action.');
    }
}

$user = $_SESSION['user'];
$userId = getID($user, $conn); // Ensure getID is compatible with PDO

// Fetch pending and accepted friends
$pendingReceived = fetchFriends($conn, 'PENDING', 'receiver', $user);
$pendingSent = fetchFriends($conn, 'PENDING', 'sender', $user);
$acceptedFriends = array_merge(
    fetchFriends($conn, 'ACCEPTED', 'receiver', $user),
    fetchFriends($conn, 'ACCEPTED', 'sender', $user)
);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Friends Page</title>
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link rel="stylesheet" href="static/css/my.css">
</head>

<body>
    <div class="master-container">
        <?php require("navbar.php"); ?>
        <div class="row profile user-home">
            <div class="col">

                <!-- RECEIVED -->
                <div class="friends">
                    <div class="heading">
                        <center>Pending Requests</center>
                    </div>
                    <div class="inner">
                        <?php
                        if (empty($pendingReceived)) {
                            echo "<div>You have no pending friend requests.</div>";
                        } else {
                            foreach ($pendingReceived as $row) {
                                echo "<div class='person'><a href='profile.php?id=" . getID($row['sender'], $conn) . "'><center><b>" . htmlspecialchars($row['sender']) . "</b></center><br><img width='125px' src='pfp/" . htmlspecialchars(getPFP($row['sender'], $conn)) . "'></a><br>
                                <a href='friends.php?action=accept&id=" . htmlspecialchars($row['id']) . "'><button>Accept</button></a> <a href='revoke.php?id=" . htmlspecialchars($row['id']) . "'><button>Decline</button></a></div>";
                            }
                            echo "<div><b>" . count($pendingReceived) . "</b> pending friend requests.</div>";
                        }
                        ?>
                    </div>
                </div>

                <!-- SENT -->
                <div class="friends">
                    <div class="heading">
                        <center>Pending Sent</center>
                    </div>
                    <div class="inner">
                        <?php
                        if (empty($pendingSent)) {
                            echo "<div>You have no pending friend requests.</div>";
                        } else {
                            foreach ($pendingSent as $row) {
                                echo "<div class='person'><a href='profile.php?id=" . getID($row['receiver'], $conn) . "'><center><b>" . htmlspecialchars($row['receiver']) . "</b></center><br><img width='125px' src='pfp/" . htmlspecialchars(getPFP($row['receiver'], $conn)) . "'></a><br>
                                <a href='revoke.php?id=" . htmlspecialchars($row['id']) . "'><button>Revoke</button></a></div>";
                            }
                            echo "<div><b>" . count($pendingSent) . "</b> pending friend requests.</div>";
                        }
                        ?>
                    </div>
                </div>

                <!-- ACCEPTED -->
                <div class="friends">
                    <div class="heading">
                        <center>Friends</center>
                    </div>
                    <div class="inner">
                        <?php
                        if (empty($acceptedFriends)) {
                            echo "<div>You have no friends...</div>";
                        } else {
                            foreach ($acceptedFriends as $friend) {
                                // Determine whether to display the sender or receiver as the friend
                                $friendUsername = $user === $friend['sender'] ? $friend['receiver'] : $friend['sender'];

                                $friendId = getID($friendUsername, $conn);
                                $friendPfp = getPFP($friendUsername, $conn);

                                echo "<div class='person'><a href='profile.php?id=" . htmlspecialchars($friendId) . "'><center><b>" . htmlspecialchars($friendUsername) . "</b></center><br><img width='125px' src='pfp/" . htmlspecialchars($friendPfp) . "'></a><br>
            <a href='friends.php?action=remove&id=" . htmlspecialchars($friend['id']) . "'><button>Remove</button></a></div>";
                            }
                            echo "<div>You have <b>" . count($acceptedFriends) . "</b> friends.</div>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>