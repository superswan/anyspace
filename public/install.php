<?php
require("../core/conn.php");
require_once("../lib/password.php");

try {
    // Begin Transaction
    $conn->beginTransaction();

    // SQL statements to create tables
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
        `last_logon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
        `lastactive` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `lastlogon` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

    $sqlInsertUser = "INSERT INTO `users` (`id`, `username`, `email`, `password`, `date`, `bio`, `interests`, `css`, `music`, `pfp`, `currentgroup`, `status`) 
    VALUES (1, 'Adam', 'adam@example.com', ?, NOW(), '', '', '', 'default.mp3', 'default.jpg', 'None', '');";

    $stmt = $conn->prepare($sqlInsertUser);
    $stmt->execute(array($hashedPassword));

    echo "Default user 'Adam' (adam@example.com) created successfully with password: $password<br>";
    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    echo "Installation failed: " . $e->getMessage();
}

$conn = null;
