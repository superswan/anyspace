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
            <?php
                if(@$_POST) {
                    $stmt = $conn->prepare("INSERT INTO `blogs` (text, author, date, title) VALUES (?, ?, now(), ?)");
                    $stmt->bind_param("sss", $text, $_SESSION['user'], $name);
                    $unprocessedText = replaceBBcodes($_POST['desc']);
                    $text = str_replace(PHP_EOL, "<br>", $unprocessedText);
                    $name = htmlspecialchars($_POST['groupname']);
                    $stmt->execute();
                    $stmt->close();            
                    header("Location: blogs.php");              
                }
            ?>
            <form method="post" enctype="multipart/form-data">
                <input required placeholder="Title" size="50" type="text" name="groupname"><br>
				<textarea required rows="10" cols="68" placeholder="Text" name="desc"></textarea><br>
				<input name="submit" type="submit" value="Create"> <small>max limit: 500 characters</small>
            </form>
        </div>
    </body>
</html>
