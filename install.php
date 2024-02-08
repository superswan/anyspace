<?php
require("func/conn.php"); 
require("lib/password.php"); 

try {
    // Begin Transaction
    $conn->beginTransaction();

    // SQL statements to create tables
    $commands = array(
        "CREATE TABLE `blogs` (
            `id` int NOT NULL AUTO_INCREMENT,
            `text` text NOT NULL,
            `author` varchar(255) NOT NULL,
            `date` datetime NOT NULL,
            `title` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",
          
        "CREATE TABLE `comments` (
            `id` int NOT NULL AUTO_INCREMENT,
            `toid` int NOT NULL,
            `author` varchar(255) NOT NULL,
            `text` varchar(500) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",
          
        "CREATE TABLE `friends` (
            `id` int NOT NULL AUTO_INCREMENT,
            `sender` varchar(255) NOT NULL,
            `receiver` varchar(255) NOT NULL,
            `status` varchar(255) NOT NULL DEFAULT 'PENDING',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",
          
        "CREATE TABLE `groupcomments` (
            `id` int NOT NULL AUTO_INCREMENT,
            `toid` int NOT NULL,
            `author` varchar(255) NOT NULL,
            `text` varchar(500) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",
          
        "CREATE TABLE `groups` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `description` varchar(500) NOT NULL,
            `author` varchar(255) NOT NULL,
            `date` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;",
          
        "CREATE TABLE `users` (
            `id` int NOT NULL AUTO_INCREMENT,
            `username` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `date` datetime NOT NULL,
            `bio` varchar(500) NOT NULL DEFAULT '',
            `interests` varchar(500) NOT NULL DEFAULT ' ',
            `css` varchar(5000) NOT NULL DEFAULT '',
            `music` varchar(255) NOT NULL DEFAULT 'default.mp3',
            `pfp` varchar(255) NOT NULL DEFAULT 'default.jpg',
            `currentgroup` varchar(255) NOT NULL DEFAULT 'None',
            `status` varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;"
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

    $sqlInsertUser = "INSERT INTO `users` (`username`, `email`, `password`, `date`, `bio`, `interests`, `css`, `music`, `pfp`, `currentgroup`, `status`) 
    VALUES ('Adam', 'adam@example.com', ?, NOW(), '', '', '', 'default.mp3', 'default.jpg', 'None', '');";

    $stmt = $conn->prepare($sqlInsertUser);
    $stmt->execute(array($hashedPassword));

    echo "Default user 'Adam' created successfully with password: $password<br>";
    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    echo "Installation failed: " . $e->getMessage();
}

$conn = null;
?>
