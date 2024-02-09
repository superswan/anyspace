<?php
require("func/conn.php");
require_once("func/settings.php");
require("func/site/friend.php");
require_once("func/site/user.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Page is used as a single entry point for friends actions
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$user = $_SESSION['user'];
$userId = $_SESSION['userId']; 

// Fetch pending and accepted friends
$pendingReceived = fetchFriends($conn, 'PENDING', 'receiver', $userId);
$pendingSent = fetchFriends($conn, 'PENDING', 'sender', $userId);
$acceptedFriends = array_merge(
    fetchFriends($conn, 'ACCEPTED', 'receiver', $userId),
    fetchFriends($conn, 'ACCEPTED', 'sender', $userId)
);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Requests |
        <?= (SITE_NAME) ?>
    </title>
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link rel="stylesheet" href="static/css/my.css">
</head>

<body>
    <div class="master-container">
        <?php require("navbar.php"); ?>
        <main>
            <div class="simple-container">
                <!-- RECEIVED -->
                <div class="friends">
                    <div class="heading">
                        <h1>Friend Requests</h1>
                    </div>
                    <div class="inner">
                        <br>
                        <p><b><span class="count">
                                    <?= count($pendingReceived); ?>
                                </span> Open Friend Requests</b></p>
                        <form method="post">
                            <input type="hidden" name="type" value="accept_all_requests">
                            <button type="submit" name="submit">Accept All Requests</button>
                        </form>
                        <br>
                        <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff" border="1">
                            <tbody>
                                <?php
                                if (empty($pendingReceived)) { // Make sure this matches the variable name used below
                                    echo "<div>You have no pending friend requests.</div>";
                                } else {
                                    foreach ($pendingReceived as $request): // Ensure this matches the variable checked above
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="profile.php?id=<?= $request['sender']; ?>">
                                                    <p>
                                                        <?= htmlspecialchars(fetchName($request['sender'])); ?>
                                                    </p>
                                                </a>
                                                <a href="profile.php?id=<?= $request['sender']; ?>">
                                                    <?php
                                                    // Since PHP 5.3 does not support the null coalescing operator, use a ternary operator as an alternative
                                                    $pfpPath = fetchPFP($request['sender']);
                                                    $pfpPath = $pfpPath ? $pfpPath : 'default.png';
                                                    ?>
                                                    <img class="pfp-fallback" src="pfp/<?= htmlspecialchars($pfpPath); ?>"
                                                        alt="profile picture" loading="lazy" width="50px">
                                                </a>
                                            </td>
                                            <td>
                                                <p><b>Friend Request</b></p>
                                                <form method="post">
                                                    <input type="hidden" name="type" value="friend-request">
                                                    <input type="hidden" name="request_id"
                                                        value="<?= htmlspecialchars($request['id']); ?>">
                                                    <button
                                                        onclick="location.href='friends.php?action=accept&id=<?= $request['sender'] ?>'"
                                                        name="decision" value="accept" type="button">Accept</button>
                                                    <button
                                                        onclick="location.href='friends.php?action=revoke&id=<?= $request['sender'] ?>'"
                                                        type="button" name="decision" value="decline">Decline</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <hr>

                    <!-- SENT -->
                    <div class="heading">
                        <h1>Sent Requests</h1>
                    </div>
                    <div class="inner">
                        <br>
                        <p><b><span class="count">
                                    <?= count($pendingSent) ?>
                                </span> Open Friend Requests</b></p>
                        <br>
                        <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff" border="1">
                            <tbody>
                                <?php
                                if (empty($pendingSent)) { // Make sure this matches the variable name used below
                                    echo "<div>You have no pending sent friend requests.</div>";
                                } else {
                                    foreach ($pendingSent as $request):
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="profile.php?id=<?= $request['receiver']; ?>">
                                                    <p>
                                                        <?= htmlspecialchars(fetchName($request['receiver'])); ?>
                                                    </p>
                                                </a>
                                                <a href="profile.php?id=<?= $request['receiver']; ?>">
                                                    <?php
                                                    $pfpPath = fetchPFP($request['receiver']);
                                                    $pfpPath = $pfpPath ? $pfpPath : 'default.png';
                                                    ?>
                                                    <img class="pfp-fallback" src="pfp/<?= htmlspecialchars($pfpPath); ?>"
                                                        alt="profile picture" loading="lazy" width="50px">
                                                </a>
                                            </td>
                                            <td>
                                                <p><b>Sent Friend Request</b></p>
                                                <form method="post">
                                                    <input type="hidden" name="type" value="friend-request">
                                                    <input type="hidden" name="request_id"
                                                        value="<?= htmlspecialchars($request['id']); ?>">
                                                    <button type="submit" name="decision" value="accept">Cancel
                                                        Friend-Request</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                </div>

            </div>

    </div>
    </main>
    </div>
</body>

</html>