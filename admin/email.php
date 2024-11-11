<?php
// Site functions
require("../core/conn.php");
require_once("../core/settings.php");

// Page functions
require("../core/site/admin/email.php");

login_check();

$email_config = get_email_config();


require("header.php");
?>

<div class="simple-container">
    <div class="row edit-profile">
        <div class="col w-20 left">
            <!-- SIDEBAR CONTENT -->
        </div>
        <div class="col right">
            <h1>Email Settings</h1>
            <p>Configure your site's email settings here</p>
            <form method="post" class="ctrl-enter-submit">
                <button type="submit" name="submit">Save All</button>
                <br>
                <label for="category_smtp_host">
                    <h3>SMTP Host:</h3>
                </label>
                <p>The hostname of your SMTP server</p>
                <input type="text" maxlength="65" class="status_input" id="category_smtp_host" name="category[smtp_host]" value="<?= htmlspecialchars($email_config['smtp_host']) ?>">

                <label for="category_smtp_port">
                    <h3>SMTP Port:</h3>
                </label>
                <p>The port number for your SMTP server</p>
                <input type="text" maxlength="5" class="status_input" id="category_smtp_port" name="category[smtp_port]" value="<?= htmlspecialchars($email_config['smtp_port']) ?>">

                <label for="category_smtp_username">
                    <h3>SMTP Username:</h3>
                </label>
                <p>The username for your SMTP server</p>
                <input type="text" maxlength="65" class="status_input" id="category_smtp_username" name="category[smtp_username]" value="<?= htmlspecialchars($email_config['smtp_username']) ?>">

                <label for="category_smtp_password">
                    <h3>SMTP Password:</h3>
                </label>
                <p>The password for your SMTP server</p>
                <input type="password" maxlength="65" class="status_input" id="category_smtp_password" name="category[smtp_password]" value="<?= htmlspecialchars($email_config['smtp_password']) ?>">

                <label for="category_from_email">
                    <h3>From Email:</h3>
                </label>
                <p>The email address that will appear as the sender</p>
                <input type="email" maxlength="65" class="status_input" id="category_from_email" name="category[from_email]" value="<?= htmlspecialchars($email_config['from_email']) ?>">

                <label for="category_require_verification">
                    <h3>Require Verification:</h3>
                </label>
                <p>Check this box to require email verification for new accounts</p>
                <input type="checkbox" id="category_require_verification" name="category[require_verification]" <?= $email_config['require_verification'] ? 'checked' : '' ?>>

                <p></p>
                <button type="submit" name="submit">Save All</button>
            </form>
            <?php
            if (isset($_GET['status']) && $_GET['status'] === 'success') {
                echo "<p style='color: green;'>Email settings updated successfully.</p>";
            } elseif (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php require("../public/footer.php"); ?>