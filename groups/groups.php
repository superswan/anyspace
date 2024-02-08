<?php
    require("func/conn.php");
    require_once("func/settings.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/base.css">
    </head>
    <body>
        <?php
            require("navbar.php");
        ?>
        <div class="container">
            <h1>Groups [wip]</h1>
            <a href="newgroup.php">make a new group</a><br><hr>
            <?php
                $stmt = $conn->prepare("SELECT * FROM `groups`");
                $stmt->execute();
                $result = $stmt->get_result();
                
                while($row = $result->fetch_assoc()) {
                    echo "<small><a href='viewgroup.php?id=" . $row['id'] . "'>[view group]</a></small> <b>" . $row['name'] . "</b> - " . $row['description'] . "<a style='float: right;' href='joingroup.php?id=" . $row['id'] . "'><button>Join Group</button></a><br><small>" . $row['author'] . "@" . $row['date'] . "</small><hr>";
                }
            ?>
        </div>
    </body>
</html>