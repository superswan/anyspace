<?php
    require("core/conn.php");
    require_once("core/settings.php");
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
                    $stmt = $conn->prepare("INSERT INTO `groups` (name, description, author, date) VALUES (?, ?, ?, now())");
                    $stmt->bind_param("sss", $name, $text, $_SESSION['user']);
                    $text = str_replace(PHP_EOL, "<br>", $_POST['desc']);
                    $name = htmlspecialchars($_POST['groupname']);
                    $stmt->execute();
                    $stmt->close();            

                    $stmt = $conn->prepare("UPDATE users SET currentgroup = ? WHERE username = ?");
                    $stmt->bind_param("ss", $groupname, $_SESSION['user']);
                    $groupname = htmlspecialchars($_POST['groupname']);
                    $stmt->execute();
                    $stmt->close();  
                    header("Location: groups.php");              
                }
            ?>
            <form method="post" enctype="multipart/form-data">
                <input required placeholder="Name" size="90" type="text" name="groupname"><br>
				<textarea required rows="10" cols="68" placeholder="Description" name="desc"></textarea><br>
				<input name="submit" type="submit" value="Create"> <small>max limit: 500 characters</small>
            </form>
        </div>
    </body>
</html>
