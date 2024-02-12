<?php
require("func/conn.php"); 
require_once("func/settings.php");
require("lib/password.php");

if (isset($_SESSION['user'])) {
    header("Location: home.php");
    exit;
}

$message = ''; 



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['password']) && !empty($_POST['username']) && !empty($_POST['confirm'])) {
        if ($_POST['password'] !== $_POST['confirm'] || strlen($_POST['username']) > 21) {
            $message = "<small>Passwords do not match up or username is too long.</small>";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute(array($_POST['username']));
            if ($stmt->fetch()) {
                $message .= "<small>There's already a user with that same name!</small><br>";
                $namecheck = false;
            } else {
                $namecheck = true;
            }

            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute(array($_POST['email']));
            if ($stmt->fetch()) {
                $message .= "<small>There's already a user with that same email!</small><br>";
                $emailcheck = false;
            } else {
                $emailcheck = true;
            }

            if ($namecheck && $emailcheck) {
                $interests = array(
                    "General" => "",
                    "Music" => "",
                    "Movies" => "",
                    "Television" => "",
                    "Books" => "",
                    "Heroes" => ""
                );
                $jsonInterests = json_encode($interests);

                $stmt = $conn->prepare("INSERT INTO users (username, email, password, date, interests) VALUES (?, ?, ?, NOW(), ?)");
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $username = htmlspecialchars($_POST['username']);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt->execute(array($username, $email, $password, $jsonInterests));

                $_SESSION['user'] = $username;
                header("Location: manage.php");
                exit;
            }
        }
    } else {
        $message = "<small>Please fill in all required fields.</small>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
</head>

<body>
    <div class="master-container">
        <?php require("navbar.php"); ?>
        <main>
            <div class="center-container">
                <h1>Register!</h1>
                <div class="contactInfo">
                    <div class="contactInfoTop">
                        <center>Benefits</center>
                    </div>
                    - Make new friends!<br>
                    - Talk to people!<br>
                    - Algorithm Free!
                </div>
                <br>
                <?php if ($message)
                    echo $message; ?>
                <form action="" method="post">
                    <input required placeholder="Username" type="text" name="username"><br>
                    <input required placeholder="E-Mail" type="email" name="email"><br>
                    <input required placeholder="Password" type="password" name="password"><br>
                    <input required placeholder="Confirm Password" type="password" name="confirm"><br><br>
                    <input type="submit" value="Register">
                </form>
            </div>
        </main>
    </div>
</body>

</html>