<?php
require("../core/conn.php");
require_once("../core/settings.php");
require("../core/site/friend.php");
require("../core/site/user.php");

login_check();

$user = $_SESSION['user'];
$userId = $_SESSION['userId'];

// Page is used as a single entry point for friends actions
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;


if (!empty($action)) {
    switch ($action) {
        case 'accept':
            acceptFriend($id, $userId);
            break;
        case 'add':
            addFriend($userId, $id);
            break;
        case 'revoke':
            revokeFriend($userId, $id);
            break;
        case 'remove':
            removeFriend($userId, $id);
            break;
        default:
            exit('Invalid action.');
    }
}


// Fetch pending and accepted friends
$acceptedFriends = array_merge(
    fetchFriends($conn, 'ACCEPTED', 'receiver', $id),
    fetchFriends($conn, 'ACCEPTED', 'sender', $id)
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
        <?php require("../core/components/navbar.php"); ?>
        <main>
            <div class="simple-container">
                <h1>
                    <?= htmlspecialchars(fetchName($id)) ?>'s Friends'
                </h1>
                <p><a href="profile.php?id=<?= $id ?>">&laquo; Back to
                        <?= htmlspecialchars(fetchName($id)) ?>'s Profile
                    </a></p>
                <br>
                <form metrhod="get">
                    <input type="hidden" name="id" value="">
                    <input type="text" name="q" value="" autocomplete="off" autofocus required>
                    <button type="submit">Search</button>
                </form>
                <br>
                <!-- ACCEPTED -->
                <div class="new-people">
                    <div class="top">
                        <h4>Friends</h4>
                    </div>
                    <div class="inner">
                        <?php
                        if (empty($acceptedFriends)) {
                            echo "<div>This user has no friends...</div>";
                        } else {
                            foreach ($acceptedFriends as $friend) {
                                $friendId = $id === $friend['sender'] ? $friend['receiver'] : $friend['sender'];
                                if ($friendId == $id) {
                                    $friendId = $friend['receiver'];
                                }
                                
                                printPerson($friendId);
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
    </div>
    </main>
    </div>

</body>

</html>