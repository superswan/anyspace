<?php
// EDIT PROFILE page
require("func/conn.php");
require_once("func/settings.php");

$stmt = $conn->prepare("SELECT * FROM `users` WHERE username=?");
$stmt->execute(array($_SESSION['user']));



while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $bio = $row['bio'];
    $css = $row['css'];
    $id = $row['id'];
    $interests = $row['interests'];
}

function prepareAndExecute($query, $params)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

$stmt = $conn->prepare("SELECT interests FROM users WHERE username = ?");
$stmt->execute(array($_SESSION['user']));
$userInterests = $stmt->fetchColumn();

// Decode the JSON string back into an array
$interests = json_decode($userInterests, true) ?: array("General" => "", "Music" => "", "Movies" => "", "Television" => "", "Books" => "", "Heroes" => "");

if (@$_POST['interestset']) {
    // This is probably an XSS vuln
    $sanitizedInterests = array_map(function($interest) {
        return $interest; 
    }, $_POST['interests']);
    
    $jsonInterests = json_encode($sanitizedInterests);
    
    $stmt = $conn->prepare("UPDATE users SET interests = ? WHERE username = ?");
    $stmt->execute(array($jsonInterests, $_SESSION['user']));

    header("Location: manage.php");
} else if (@$_POST['bioset']) {
    $unprocessedText = replaceBBcodes($_POST['bio']);
    $text = str_replace(PHP_EOL, "<br>", $unprocessedText);
    prepareAndExecute("UPDATE users SET bio = ? WHERE `users`.`username` = ?", array($text, $_SESSION['user']));
    header("Location: manage.php");
} else if (@$_POST['statusset']) {
    $text = htmlspecialchars($_POST['status']);
    prepareAndExecute("UPDATE users SET status = ? WHERE `users`.`username` = ?", array($text, $_SESSION['user']));
    header("Location: manage.php");
} else if (@$_POST['cssset']) {
    $validatedcss = validateCSS($_POST['css']);
    prepareAndExecute("UPDATE users SET css = ? WHERE `users`.`username` = ?", array($validatedcss, $_SESSION['user']));
    header("Location: manage.php");
} else if (@$_POST['submit']) {
    $target_dir = "pfp/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }
    if (file_exists($target_file)) {
        echo 'file with the same name already exists<hr>';
        $uploadOk = 0;
    }
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo 'unsupported file type. must be jpg, png, jpeg, or gif<hr>';
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Prepare the statement using PDO syntax
            $stmt = $conn->prepare("UPDATE users SET pfp = :filename WHERE `users`.`username` = :username");

            // Bind the parameters to the query
            $filename = basename($_FILES["fileToUpload"]["name"]);
            $username = $_SESSION['user'];

            // Execute the statement with the bound parameters
            $stmt->execute(array(':filename' => $filename, ':username' => $username));
        } else {
            echo 'fatal error<hr>';
        }
    }
} else if (@$_POST['photoset']) {
    $target_dir = "music/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }
    if (file_exists($target_file)) {
        echo 'file with the same name already exists<hr>';
        $uploadOk = 0;
    }
    if ($imageFileType != "ogg" && $imageFileType != "mp3") {
        echo 'unsupported file type. must be mp3 or ogg<hr>';
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Prepare the statement using PDO syntax
            $stmt = $conn->prepare("UPDATE users SET music = :filename WHERE `users`.`username` = :username");

            // Bind the parameters to the query
            $filename = basename($_FILES["fileToUpload"]["name"]);
            $username = $_SESSION['user'];

            // Execute the statement with the bound parameters
            $stmt->execute(array(':filename' => $filename, ':username' => $username));
        } else {
            echo 'fatal error' . $_FILES["fileToUpload"]["error"] . '<hr>';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link rel="stylesheet" href="static/css/my.css">
</head>

<body>
    <div class="master-container">
        <?php require("navbar.php"); ?>
        <main>
            <div class="row edit-profile">
                <div class="col w-20 left"></div>
                <div class="col right">
                    <h2>Edit Profile</h2>
                    <p>All fields are optional and can be left empty</p>
                    <div class="profile-pic">
                        <?php
                        echo '<img width="180px" height="auto" src="pfp/' . getPFP($_SESSION['user'], $conn) . '"><h2>' . htmlspecialchars($_SESSION['user']) . '</h1>';
                        ?>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <small>Select photo:</small>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                    <form method="post" enctype="multipart/form-data">
                        <small>Select song:</small>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Song" name="photoset">
                    </form>
                    <br>
                    <b>Bio</b>
                    <form method="post" enctype="multipart/form-data">
                        <textarea required cols="58" placeholder="Bio" name="bio"><?php echo $bio; ?></textarea><br>
                        <input name="bioset" type="submit" value="Set"> <small>max limit: 500 characters | supports
                            bbcode</small>
                    </form>
                    <br>
                    <b>Interests</b>
                    <form method="post" enctype="multipart/form-data">
                        <label for="general">General:</label>
                        <input type="text" id="general" name="interests[General]"
                            value="<?php echo htmlspecialchars($interests['General']); ?>"><br>

                        <label for="music">Music:</label>
                        <input type="text" id="music" name="interests[Music]"
                            value="<?php echo htmlspecialchars($interests['Music']); ?>"><br>

                        <label for="movies">Movies:</label>
                        <input type="text" id="movies" name="interests[Movies]"
                            value="<?php echo htmlspecialchars($interests['Movies']); ?>"><br>

                        <label for="television">Television:</label>
                        <input type="text" id="television" name="interests[Television]"
                            value="<?php echo htmlspecialchars($interests['Television']); ?>"><br>

                        <label for="books">Books:</label>
                        <input type="text" id="books" name="interests[Books]"
                            value="<?php echo htmlspecialchars($interests['Books']); ?>"><br>

                        <label for="heroes">Heroes:</label>
                        <input type="text" id="heroes" name="interests[Heroes]"
                            value="<?php echo htmlspecialchars($interests['Heroes']); ?>"><br>

                        <input name="interestset" type="submit" value="Set">
                        <small>max limit: 500 characters | supports bbcode</small>
                    </form>

                    <br>
                    <b>CSS</b>
                    <form method="post" enctype="multipart/form-data">
                        <textarea required rows="15" cols="58" placeholder="Your CSS"
                            name="css"><?php echo $css; ?></textarea><br>
                        <input name="cssset" type="submit" value="Set"> <small>max limit: 5000 characters</small>
                    </form>
                    <br>
                    <b>Status</b>
                    <form method="post" enctype="multipart/form-data">
                        <input size="77" type="text" name="status"><br>
                        <input name="statusset" type="submit" value="Set"> <small>max limit: 255 characters</small>
                    </form>
                    <br>
                </div>
            </div>
            <?php require_once("footer.php") ?>