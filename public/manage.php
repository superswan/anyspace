<?php
// EDIT PROFILE page
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/user.php");
require_once("../core/site/edit.php");

login_check();

$userInfo = fetchUserInfo($_SESSION['userId']); // Assume this function exists and fetches user info
if ($userInfo) {
    $bio = $userInfo['bio'];
    $css = $userInfo['css'];
    $userId = $userInfo['id'];
    $interests = json_decode($userInfo['interests'], true) ?: array("General" => "", "Music" => "", "Movies" => "", "Television" => "", "Books" => "", "Heroes" => "");
} else {
    echo "User not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (@$_POST['interestset']) {
        // This is probably an XSS vuln
        $sanitizedInterests = array_map(function ($interest) {
            return $interest;
        }, $_POST['interests']);
        updateInterests($userId, $sanitizedInterests);
        header("Location: manage.php");
    } elseif (isset($_POST['usernameset'])) {
        $newUsername = trim($_POST['newUsername']);
        if (strlen($newUsername) > 50) {
            echo "<small>Username too long. Max is 50 characters.</small><br>";
        } else {
            // Update the username
            $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
            $stmt->execute(array($newUsername, $userId));
            $_SESSION['user'] = $newUsername; 
            echo "<small>Username updated successfully.</small><br>";
            header("Refresh:0"); 
        }
    } else if (@$_POST['bioset']) {
        $unprocessedText = replaceBBcodes($_POST['bio']);
        $text = str_replace(PHP_EOL, "<br>", $unprocessedText);
        updateBio($userId, $text);
        header("Location: manage.php");
    } else if (@$_POST['cssset']) {
        $validatedcss = validateCSS($_POST['css']);
        updateCSS($userId, $validatedcss);
        header("Location: manage.php");
    } else if (@$_POST['submit']) {
        uploadFile($userId, $_FILES["fileToUpload"], "media/pfp/", array('jpg', 'png', 'jpeg', 'gif'));
    } elseif (isset($_POST['photoset'])) { // For music upload
        uploadFile($userId, $_FILES["fileToUpload"], "media/music/", array('mp3', 'ogg'));
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
                    <h1>Edit Profile</h1>
                    <p>All fields are optional and can be left empty</p>
                    <a href="profile.php?id=<?= $_SESSION['userId'] ?>">&laquo; View Profile</a>
                    <div class="profile-pic">
                        <?php
                        echo '<h1>' . htmlspecialchars($_SESSION['user']) . '</h1><br>' . '<img width="180px" height="auto" src="media/pfp/' . fetchPFP($_SESSION['userId']) . '"><br>';
                        ?>
                    </div>
                    <hr>
                    <h1>Change Name:</h1>
                    <br>
                    <form method="post" enctype="multipart/form-data">
                        <input size="77" type="text" name="newUsername" placeholder="New Username"
                            value="<?php echo htmlspecialchars($_SESSION['user']); ?>"><br>
                        <input name="usernameset" type="submit" value="Change Name" style="max-width: 20%;"> <small>max: 50
                            characters</small>
                    </form>
                    <br>


                    <br>
                    <h1>Profile Picture & Song:</h1>
                    <br>
                    <form method="post" enctype="multipart/form-data">
                        <small>Select photo:</small>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                    <small>Max file size: 10MB (jpg/png/gif)</small>
                    <hr style="max-width: 80%;">
                    <br>
                    <form method="post" enctype="multipart/form-data">
                        <small>Select song:</small>
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Song" name="photoset">
                    </form>
                    <small>Max file size: 10MB (mp3/ogg)</small>
                    <hr style="max-width: 80%;">
                    <br>
                    <h1>Bio:</h1>
                    <br>
                    <form method="post" enctype="multipart/form-data">
                        <textarea required cols="58" placeholder="Bio" name="bio"><?php echo $bio; ?></textarea><br>
                        <input name="bioset" type="submit" value="Set"> <small>max limit: 500 characters | supports
                            bbcode</small>
                    </form>
                    <br>
                    <h1>Interests:</h1>
                    <br>
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
                    <h1>Layout:</h1>
                    <small>what you would normally paste into 'About me' (include 'style' tags)</small>
                    <br>
                    <form accept-charset="UTF-8" method="post" enctype="multipart/form-data">
                        <textarea required rows="15" cols="58" placeholder="Your CSS"
                            name="css"><?php echo $css; ?></textarea><br>
                        <input name="cssset" type="submit" value="Set"> <small>max limit: None</small>
                    </form>
                    <br>

                </div>
            </div>
            <?php require_once("footer.php") ?>