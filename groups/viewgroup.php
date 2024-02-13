<?php
    require("core/conn.php");
    require_once("core/settings.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/base.css">
        <?php
            $stmt = $conn->prepare("SELECT * FROM `groups` WHERE id = ?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while($row = $result->fetch_assoc()) {
                $name = $row['name'];
                $desc = $row['description'];
                $author = $row['author'];
                $date = $row['date'];
            }

            if(@$_POST["comment"]) {
                $stmt = $conn->prepare("INSERT INTO `groupcomments` (toid, author, text, date) VALUES (?, ?, ?, now())");
                $stmt->bind_param("sss", $_GET['id'], $_SESSION['user'], $text);
            
                $unprocessedText = replaceBBcodes($_POST['comment']);
                $text = str_replace(PHP_EOL, "<br>", $unprocessedText);
                $stmt->execute();
            
                $stmt->close();
                
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
                echo "Owner: <a href='profile.php?id=" . getID($author, $conn) . "'>" . $author . "</a>";
            ?>
            <pre><?php echo $desc;?></pre>
            <div class="info">
                <center>Comments</center>
            </div>
            <form method="post" enctype="multipart/form-data">
				<textarea required rows="5" cols="80" placeholder="Comment" name="comment"></textarea><br>
				<input name="submit" type="submit" value="Post"> <small>max limit: 500 characters</small>
            </form>
            <br><hr>
            <?php
                $stmt = $conn->prepare("SELECT * FROM `groupcomments` WHERE toid = ?");
                $stmt->bind_param("s", $_GET['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while($row = $result->fetch_assoc()) {
                    echo "<div class='commentRight'>";
                    echo "  <small>" . $row['date'] . "</small><br>" . $row['text'];
                    echo "  <a style='float: right;' href='profile.php?id=" . getID($row['author'], $conn) . "'>" . $row['author'] . "</a> <br>";
                    echo "  <img class='commentPictures' style='float: right;' width='80px;'src='pfp/" . getPFP($row['author'], $conn) . "'><br><br><br><br><br>";
                    echo "</div>";
                }
            ?>
        </div>
    </body>
</html>