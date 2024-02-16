<?php
require("../core/conn.php");
require_once("../core/settings.php");

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // Define the path to the settings file
        $settingsFilePath = "../core/config.php";
        
        // Validate and sanitize input
        $siteName = filter_input(INPUT_POST, 'category[status]', FILTER_SANITIZE_STRING);
        $domainName = filter_input(INPUT_POST, 'category[mood]', FILTER_SANITIZE_STRING);
        $adminUser = filter_input(INPUT_POST, 'category[you]', FILTER_VALIDATE_INT);
    
        // Read the current settings from the file
        $settingsContent = file_get_contents($settingsFilePath);
    
        // Update the content
        if ($siteName) {
            $settingsContent = preg_replace("/(\\\$siteName\s*=\s*['\"])(.*?)(['\"])/", "$1$siteName$3", $settingsContent);
        }
        if ($domainName) {
            $settingsContent = preg_replace("/(\\\$domainName\s*=\s*['\"])(.*?)(['\"])/", "$1$domainName$3", $settingsContent);
        }
    
        // Save the updated settings to the file
        file_put_contents($settingsFilePath, $settingsContent);
    
        // Redirect or display a success message
        header("Location: index.php?status=success");
        exit;
    }

require("../core/config.php");
?>

<?php require("header.php"); ?>

<div class="simple-container">
    <div class="row edit-profile">
    <div class="col w-20 left">
        <!-- SIDEBAR CONTENT -->
    </div>
    <div class="col right">
        <h1>General Settings</h1>
        <p>Here you can change general site-wide settings</p>
        <form method="post" class="ctrl-enter-submit">
            <button type="submit" name="submit">Save All</button>
            <br>
            <label for="category_status">
                <h3>Site Name:</h3>
            </label>
            <p>Will be dispalyed in titles, page headings, and info boxes</p><input type="text" maxlength="65" class="status_input"
                id="category_status" name="category[status]" value="<?= $siteName ?>">
                <h3>Domain Name:</h3>
            </label>
            <p>full domain name</p><input type="text" maxlength="65" class="status_input"
                id="category_mood" name="category[mood]" value="<?= $domainName ?>">
            <p><b>Example:</b> <i>anyspace.3to.moe</i></p><br><label for="category_mood">
                <h3>Admin ID:</h3>
            </label>
            <p>ID only of admin user</p><input type="text" maxlength="65" class="status_input"
                id="category_you" name="category[you]" value="<?= $adminUser ?>">
                <p></p>
            <button type="submit" name="submit">Save All</button>
        </form>
    </div>
</div>
</div>

<?php require("../public/footer.php"); ?>