<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/user.php");

login_check();

require("../core/config.php");

$userId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = fetchUserInfo($userId);

if (!$user) {
    header("Location: users.php");
    exit;
}

$actionMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['resend_verification'])) {
        // Implement resend verification email logic
        $actionMessage = "Verification email resent.";
    } elseif (isset($_POST['manually_verify'])) {
        // Implement manual verification logic
        $actionMessage = "User manually verified.";
    } elseif (isset($_POST['ban_user'])) {
        // Implement ban user logic
        $actionMessage = "User banned.";
    } elseif (isset($_POST['unban_user'])) {
        // Implement unban user logic
        $actionMessage = "User unbanned.";
    } elseif (isset($_POST['send_password_reset'])) {
        // Implement send password reset email logic
        $actionMessage = "Password reset email sent.";
    } elseif (isset($_POST['change_password'])) {
        $newPassword = $_POST['new_password'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        changePassword($userId, $hashedPassword);
        $actionMessage = "Password changed successfully.";
    }
}

?>

<?php require("header.php"); ?>

<div class="simple-container">
    <h1>Modify User: <?php echo htmlspecialchars(fetchName($userId)); ?></h1>
    
    <?php if ($actionMessage): ?>
        <div class="alert"><?php echo $actionMessage; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <h2>User Information</h2>
        <p>Username: <?php echo htmlspecialchars(fetchName($userId)); ?></p>
        <p>Email: <?php echo htmlspecialchars(fetchEmail($userId)); ?></p>
        <p>Profile Picture: <img src="<?php echo htmlspecialchars(fetchPFP($userId)); ?>" alt="Profile Picture" style="width: 50px; height: 50px;"></p>

        <h2>Admin Actions</h2>
        <button type="submit" name="resend_verification">Resend Verification Email</button>
        <button type="submit" name="manually_verify">Manually Verify Account</button>
        
        <?php 
        $userStatus = fetchUserStatus($userId);
        $isBanned = isset($userStatus['banned']) && $userStatus['banned'];
        ?>
        <?php if ($isBanned): ?>
            <button type="submit" name="unban_user">Unban User</button>
        <?php else: ?>
            <button type="submit" name="ban_user">Ban User</button>
        <?php endif; ?>

        <button type="submit" name="send_password_reset">Send Password Reset Email</button>

        <h2>Change Password</h2>
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit" name="change_password">Change Password</button>
    </form>

    <a href="users.php">Back to User List</a>
</div>

<?php require("../public/footer.php"); ?>
