<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../lib/password.php");
require("../core/site/user.php");
require("../core/site/edit.php");


login_check();

$userId = $_SESSION['userId'];

if (isset($_POST['password-old']) && isset($_POST['password-new']) && isset($_POST['password-confirm'])) {
    $oldPassword = $_POST['password-old'];
    $newPassword = $_POST['password-new'];
    $confirmPassword = $_POST['password-confirm'];

    $currentUserPassword = fetchUserPassword($userId); 
    $currentUserPassword = $currentUserPassword['password']; 

    if (password_verify($oldPassword, $currentUserPassword)) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            changePassword($userId, $hashedPassword); 

            echo "Password updated successfully.";
        } else {
            echo "New passwords do not match.";
        }
    } else {
        echo "Old password is incorrect.";
    }
}

?>
<?php require("header.php"); ?>

<div class="simple-container">
  <h1>Account Settings</h1>
    <form method="post" class="ctrl-enter-submit">
    <div class="setting-section">
      <div class="heading">
        <h4>Basic Details</h4>
      </div>
      <div class="inner">
        <label for="id">Account ID:</label>
        <input type="text" id="id" value="<?= $userId ?>" readonly disabled>
        <br>
        <br>
        <label for="name">Email Address:</label>
        <input type="email" id="email" name="email" autocomplete="email" value="<?= fetchEmail($userId) ?>" required>
        <br>
        <br>
        <label for="name">Your Name:</label>
        <input type="text" id="name" value="<?= fetchName($userId) ?>" readonly disabled>
        <small>Change on the <a href="manage.php">Edit Profile</a> page</small>
        <!-- Currently Not Implemented
        <br>
        <br>
        <label for="username">Username: (optional)</label>
        <span class="username-box">
          https://<?= DOMAIN_NAME ?>/
          <input type="text" id="username" name="username" autocomplete="username" value="">
        </span>
        <p class="info">
          If you set a Username, you will get a custom URL for your Profile. Example: <b>https://<?= DOMAIN_NAME ?>/username</b><br><br>
          <b>Attention:</b> If you change your Username, your previous Profile URL won't work anymore and your Username will be available for other people again!
        </p>
          -->
      </div>
    </div>
        <div class="setting-section">
      <div class="heading">
        <h4>Change Password</h4>
      </div>
      <div class="inner">
      <label for="id">Old Password:</label>
        <input type="password" id="id" value="" name="password-old" noautocomplete>
        <br>
        <br>
        <label for="name">New Password:</label>
        <input type="password" id="id" value="" name="password-new" noautocomplete>
        <br>
        <br>
        <label for="name">Confirm New Password:</label>
        <input type="password" id="id" value="" name="password-confirm" noautocomplete>
      </div>
    </div>
    <div class="setting-section">
      <div class="heading">
        <h4>Privacy</h4>
      </div>
      <div class="inner">
        <!-- real check doesn't exist yet
        <label for="show_online">Online Status:</label>
        <input type="checkbox" id="show_online" name="show_online" checked> Show Online Status on your Profile
                <br>
        <br>
    
        <label for="im_privacy">Who can start an IM conversation with you:</label>
        <select name="im_privacy" id="im_privacy" required>
          <option value="friends" selected>Your Friends</option>
          <option value="everyone" >Everyone</option>
          <option value="noone" >No one</option>
        </select>
        <br>
        <br>
          -->
        <label for="profile_visibility">Who can view your Profile:</label>
        <select name="profile_visibility" id="profile_visibility" required>
          <option value="public" selected>Everyone (Public)</option>
          <option value="private" >Only Friends (Private)</option>
        </select>
        <p class="info">If your Profile is set to <b>private</b>, only Friends can view the content of your Profile. All other content posted by you will stay public.</p>

      </div>
    </div>

    <!-- 
    <div class="setting-section">
      <div class="heading">
        <h4>Security & Account Access</h4>
      </div>
      <div class="inner">
        <label for="2fa">2-Factor-Authentication:</label>
        <span id="2fa">
          <i>not enabled</i> [<a href="/enable2fa">enable</a>]        </span>
        <h4 style="margin: 15px 0 0 0;">Active Sessions:</h4>
        <table class="settings-sessions-table" border="1" cellspacing="0" cellpadding="3">
          <tr>
            <th>Client</th>
            <th>Device</th>
            <th>Last used</th>
            <th style="text-align:center;">Action</th>
          </tr>
                      <tr>
                       </td>
            </tr>
                  </table>
      </div>
    </div>
    <br>
          -->
    <button type="submit" name="submit">Save All</button>
  </form>
  <br>
  <h4 style="margin-bottom: 5px;">More Options</h4>
  <!--
  <ul>
    <li>Export your Account Data: <a href="/export" target="_blank">Download</a></li>
    <li>If you want to permanently delete your Account and all your data, please <a href="deleteaccount.php">click here</a></li>
  </ul>
          -->
</div>


<?php require("footer.php"); ?>