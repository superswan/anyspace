<?php
require("../core/conn.php");
require_once("../lib/password.php");

try {
    // Begin Transaction
    $conn->beginTransaction();

    // SQL statements to create tables
    $commands = array(
        "CREATE TABLE IF NOT EXISTS `blogs` (
            `id` int(11) NOT NULL,
            `text` text NOT NULL,
            `author` varchar(255) NOT NULL,
            `date` datetime NOT NULL,
            `title` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
          
        "CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL,
            `toid` int(11) NOT NULL,
            `author` varchar(255) NOT NULL,
            `text` varchar(500) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
          
        "CREATE TABLE IF NOT EXISTS `friends` (
            `id` int(11) NOT NULL,
            `sender` varchar(255) NOT NULL,
            `receiver` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL DEFAULT 'PENDING',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
          
        "CREATE TABLE IF NOT EXISTS `groupcomments` (
            `id` int(11) NOT NULL,
            `toid` int(11) NOT NULL,
            `author` varchar(255) NOT NULL,
            `text` varchar(500) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
          
        "CREATE TABLE IF NOT EXISTS `groups` (
            `id` int(11) NOT NULL,
            `name` varchar(255) NOT NULL,
            `description` varchar(500) NOT NULL,
            `author` varchar(255) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
          
        "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL,
            `username` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `date` datetime NOT NULL,
            `bio` varchar(500) NOT NULL default '',
            `interests` varchar(500) NOT NULL default ' ',
            `css` blob NOT NULL,
            `music` varchar(255) NOT NULL default 'default.mp3',
            `pfp` varchar(255) NOT NULL default 'default.jpg',
            `currentgroup` varchar(255) NOT NULL default 'None',
            `status` varchar(255) NOT NULL default '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;",
          
        "CREATE TABLE IF NOT EXISTS `blogcomments` (
            `id` int(11) NOT NULL,
            `toid` int(11) NOT NULL,
            `author` varchar(255) NOT NULL,
            `text` varchar(500) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
        
        "CREATE TABLE IF NOT EXISTS `bulletincomments` (
            `id` int(11) NOT NULL,
            `toid` int(11) NOT NULL,
            `author` varchar(255) NOT NULL,
            `text` varchar(500) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
          
        "CREATE TABLE IF NOT EXISTS `bulletins` (
            `id` int(11) NOT NULL,
            `text` text NOT NULL,
            `author` varchar(255) NOT NULL,
            `date` datetime NOT NULL,
            `title` varchar(255) NOT NULL,
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
?>
