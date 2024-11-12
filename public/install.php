<?php
// Check if config already exists
if (file_exists("../core/config.php")) {
    header("Location: index.php");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $config_file = "../core/config.php";
    touch($config_file);
    chmod($config_file, 0644);

    $config_content = "<?php\n";
    $config_content .= "// Database configuration\n";
    $config_content .= "\$host = '" . addslashes($_POST['host']) . "';\n";
    $config_content .= "\$dbname = '" . addslashes($_POST['dbname']) . "';\n";
    $config_content .= "\$username = '" . addslashes($_POST['username']) . "';\n";
    $config_content .= "\$password = '" . addslashes($_POST['password']) . "';\n\n";
    $config_content .= "// Site localization\n";
    $config_content .= "\$siteName = \"" . addslashes($_POST['siteName']) . "\";\n";
    $config_content .= "\$domainName = \"" . addslashes($_POST['domainName']) . "\";\n";
    $config_content .= "\$adminUser = 1;\n";
    $config_content .= "\n?>";

    // Try to write config file
    if (file_put_contents($config_file, $config_content)) {
        // Now we can include the new config and proceed with database setup
        require("../core/config.php");
        require("../core/conn.php");
        require_once("../lib/password.php");

        try {
            // Begin Transaction
            $conn->beginTransaction();

            // SQL statements to create tables (From anyspace.sql)
            $commands = array(
                "CREATE TABLE IF NOT EXISTS `blogs` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `text` text NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `date` datetime NOT NULL,
                    `title` varchar(255) NOT NULL,
                    `kudos` int(11) DEFAULT '0',
                    `category` int(11) NOT NULL,
                    `privacy_level` int(11) NOT NULL,
                    `pinned` tinyint(1) NOT NULL DEFAULT '0',
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `blogcomments` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `toid` int(11) NOT NULL,
                    `parent_id` int(11) DEFAULT NULL,
                    `author` varchar(255) NOT NULL,
                    `text` varchar(500) NOT NULL,
                    `date` datetime NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `bulletins` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `text` text NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `date` datetime NOT NULL,
                    `title` varchar(255) NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `bulletincomments` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `toid` int(11) NOT NULL,
                    `parent_id` int(11) NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `text` varchar(500) NOT NULL,
                    `date` datetime NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `comments` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `toid` int(11) NOT NULL,
                    `parent_id` int(11) NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `text` varchar(500) NOT NULL,
                    `date` datetime NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `favorites` (
                    `user_id` int(11) NOT NULL,
                    `favorites` text,
                    PRIMARY KEY (`user_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `friends` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `sender` varchar(255) NOT NULL,
                    `receiver` varchar(255) NOT NULL,
                    `status` varchar(255) NOT NULL DEFAULT 'PENDING',
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `groupcomments` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `toid` int(11) NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `text` varchar(500) NOT NULL,
                    `date` datetime NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `groups` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `name` varchar(255) NOT NULL,
                    `description` varchar(500) NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `date` datetime NOT NULL,
                    `members` text NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `layoutcomments` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `toid` int(11) NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `text` varchar(500) NOT NULL,
                    `date` datetime NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `layouts` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `text` text NOT NULL,
                    `author` varchar(255) NOT NULL,
                    `date` datetime NOT NULL,
                    `title` varchar(255) NOT NULL,
                    `code` blob NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `messages` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `toid` int(11) NOT NULL,
                    `author` int(11) NOT NULL,
                    `msg` text NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `reports` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `user_id` int(11) NOT NULL,
                    `creator_id` int(11) NOT NULL,
                    `date` datetime NOT NULL,
                    `content_type` int(11) NOT NULL,
                    `content_id` int(11) NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `sessions` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `session_id` varchar(16) NOT NULL,
                    `user_id` int(11) NOT NULL,
                    `user` varchar(50) NOT NULL,
                    `last_logon` datetime NULL DEFAULT NULL,
                    `last_activity` datetime NULL DEFAULT NULL,
                    `active` tinyint(1) NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",

                "CREATE TABLE IF NOT EXISTS `users` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `rank` tinyint(4) NOT NULL DEFAULT '0',
                    `username` varchar(255) NOT NULL,
                    `email` varchar(255) NOT NULL,
                    `password` varchar(255) NOT NULL,
                    `date` datetime NOT NULL,
                    `lastactive` datetime NULL DEFAULT NULL,
                    `lastlogon` datetime NULL DEFAULT NULL,
                    `bio` varchar(500) NOT NULL DEFAULT '',
                    `interests` varchar(500) NOT NULL DEFAULT ' ',
                    `css` blob NOT NULL,
                    `music` varchar(255) NOT NULL DEFAULT 'default.mp3',
                    `pfp` varchar(255) NOT NULL DEFAULT 'default.jpg',
                    `currentgroup` varchar(255) NOT NULL DEFAULT 'None',
                    `status` varchar(255) NOT NULL DEFAULT '',
                    `private` tinyint(1) NOT NULL DEFAULT '0',
                    `views` int(11) NOT NULL DEFAULT '0',
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
            );

            foreach ($commands as $command) {
                $conn->exec($command);
            }

            // Create initial user for testing
            function generateRandomPassword($length = 8) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomPassword = '';
                for ($i = 0, $charactersLength = strlen($characters); $i < $length; $i++) {
                    $randomPassword .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomPassword;
            }

            $password = generateRandomPassword();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sqlInsertUser = "INSERT INTO `users` (`id`, `rank`, `username`, `email`, `password`, `date`, `lastactive`, `lastlogon`, `bio`, `interests`, `css`, `music`, `pfp`, `currentgroup`, `status`, `private`, `views`) 
            VALUES (1, 1, ?, ?, ?, NOW(), NULL, NULL, '', '', '', 'default.mp3', 'default.jpg', 'None', '', 0, 0);";

            $stmt = $conn->prepare($sqlInsertUser);
            $stmt->execute(array($_POST['adminUsername'], $_POST['adminEmail'], $hashedPassword));

            // Display success page
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>AnySpace Installation Complete</title>
                <style>
                    body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 0 20px; }
                    .success { background: #e8f5e9; padding: 20px; border-radius: 4px; margin: 20px 0; }
                    .success a { color: #2196F3; text-decoration: none; }
                    .success a:hover { text-decoration: underline; }
                    .credentials { background: #fff3e0; padding: 20px; border-radius: 4px; margin: 20px 0; }
                </style>
            </head>
            <body>
                <h1>Installation Complete!</h1>
                
                <div class="credentials">
                    <h3>Admin Account Credentials</h3>
                    <p>Username: <?php echo htmlspecialchars($_POST['adminUsername']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($_POST['adminEmail']); ?></p>
                    <p>Password: <?php echo htmlspecialchars($password); ?></p>
                    <p><strong>Please save these credentials immediately!</strong></p>
                </div>

                <div class="success">
                    <h3>Installation Successful!</h3>
                    <p>Your AnySpace installation is complete. You can now:</p>
                    <ul>
                        <li><a href="//<?php echo htmlspecialchars($_POST['domainName']); ?>">Visit homepage</a></li>
                        <li><a href="//<?php echo htmlspecialchars($_POST['domainName']); ?>/admin/">Access the admin panel</a></li>
                    </ul>
                </div>
            </body>
            </html>
            <?php

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            echo "Installation failed: " . $e->getMessage();
        }

        $conn = null;
    } else {
        die("Failed to write config file. Please check permissions.");
    }
} else {
    // Display installation form
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>AnySpace Installation</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 0 20px; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; }
            input[type="text"], input[type="password"], input[type="email"] { width: 100%; padding: 8px; }
            .section { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        </style>
    </head>
    <body>
        <h1>AnySpace Installation</h1>
        <form method="POST">
            <div class="section">
                <h2>Database Configuration</h2>
                <div class="form-group">
                    <label>Database Host:</label>
                    <input type="text" name="host" value="localhost" required>
                </div>
                <div class="form-group">
                    <label>Database Name:</label>
                    <input type="text" name="dbname" value="anyspace" required>
                </div>
                <div class="form-group">
                    <label>Database Username:</label>
                    <input type="text" name="username" value="anyspace" required>
                </div>
                <div class="form-group">
                    <label>Database Password:</label>
                    <input type="password" name="password">
                </div>
            </div>

            <div class="section">
                <h2>Site Configuration</h2>
                <div class="form-group">
                    <label>Site Name:</label>
                    <input type="text" name="siteName" value="AnySpace" required>
                </div>
                <div class="form-group">
                    <label>Domain Name:</label>
                    <input type="text" name="domainName" value="anyspace.3to.moe" required>
                </div>
            </div>

            <div class="section">
                <h2>Admin Account</h2>
                <div class="form-group">
                    <label>Admin Username:</label>
                    <input type="text" name="adminUsername" required>
                </div>
                <div class="form-group">
                    <label>Admin Email:</label>
                    <input type="email" name="adminEmail" required>
                </div>
            </div>

            <input type="submit" value="Install AnySpace">
        </form>
    </body>
    </html>
    <?php
}
?>
