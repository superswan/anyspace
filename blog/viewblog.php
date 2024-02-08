<?php
    require("func/conn.php");
    require_once("func/settings.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/base.css">
        <?php
            $stmt = $conn->prepare("SELECT * FROM `blogs` WHERE id = ?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()) {
                $name = $row['title'];
                $desc = $row['text'];
                $author = $row['author'];
                $date = $row['date'];
            }
        ?>
    </head>
    <body>
        <?php
            require("navbar.php");
        ?>
        <div class="container">
            <h1><?php echo $name; ?></h1>
            <?php
                echo $author . "@" . $date . "<hr>";
                echo $desc;
            ?>
        </div>
    </body>
</html>