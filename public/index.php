<?php
require("../core/conn.php");
require("../core/settings.php");
require("../core/site/user.php");
require("../lib/password.php");

if (isset($_SESSION['user'])) {
    header("Location: home.php");
    exit;
}

// Process login 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'login') {
        // Sanitize input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];


        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->execute(array($email));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['userId'] = $user['id'];
            header("Location: home.php");
            exit;
        } else {
            echo '<p>Login information doesn\'t exist or incorrect password.</p><hr>';
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>
        <?= SITE_NAME ?> | A Space for Anyone
    </title>
    <link rel="icon" href="static/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="description" content="An Open Source social network">
    <link rel="stylesheet" href="static/css/normalize.css">
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link rel="stylesheet" href="static/css/my.css">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://<?= DOMAIN_NAME ?>/">
    <meta property="og:title" content="<?= SITE_NAME ?>">
    <meta property="og:description" content="A space for anyone.">
    <meta property="og:image" content="https://3to.moe/a/corespace.png">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://<?= DOMAIN_NAME ?>/">
    <meta name="twitter:title" content="<?= SITE_NAME ?>">
    <meta name="twitter:description" content="<?= SITE_NAME ?>. A space for anyone">
    <meta name="twitter:image" content="https://3to.moe/a/corespace.png">

    <!-- here for responsiveness, not in css yet -->
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        @media screen and (max-width: 768px) {
            .row.home {
                display: flex;
                flex-direction: column;
            }

            .col {
                width: 100%;
            }

            .col.right {
                width: 60%);
                margin: 0 auto;
            }

            .col.w-60 {
                width: 100%;
            }

            .master-container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="master-container">
        <?php require("../core/components/navbar.php"); ?>
        <main>
            <div class="row home">
                <div class="col w-60 left">
                    <!-- Cool New People Section -->
                    <div class="new-people cool">
                        <div class="top">
                            <h4>Cool New People</h4>
                        </div>
                        <div class="inner">
                            <?php
                            $stmt = $conn->prepare("SELECT id FROM `users` ORDER BY date DESC LIMIT 4");
                            $stmt->execute();

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                printPerson($row['id']);
                            }
                            ?>
                        </div>
                    </div>
                    <!-- Music section -->
                    <?php include("../core/components/section_music.php") ?>

                    <!-- Announcements Section -->
                    <?php include("../core/components/section_announcements.php") ?>
                </div>
                <!-- MOTD -->
                <div class="col right">
                    <div class="welcome">
                        <p>Did you know...? AnySpace is OpenSource!</p>
                    </div>
                    <div class="box">
                        <!-- Login/Signup Form -->
                        <h4>Member Login/Signup</h4>
                        <form action="" method="post" name="theForm" id="theForm">
                            <input name="client_id" type="hidden" value="web">
                            <table>
                                <tbody>
                                    <tr class="email">
                                        <td class="label"><label for="email">E-Mail:</label></td>
                                        <td class="input"><input type="email" name="email" id="email"
                                                autocomplete="email" value="" required></td>
                                    </tr>
                                    <tr class="password">
                                        <td class="label"><label for="password">Password:</label></td>
                                        <td class="input"><input name="password" type="password" id="password"
                                                autocomplete="current-password" required></td>
                                    </tr>
                                    <tr class="remember">
                                        <td></td>
                                        <td>
                                            <input type="checkbox" name="remember" value="yes" id="checkbox">
                                            <label for="checkbox">Remember my E-mail</label>
                                        </td>
                                    </tr>
                                    <tr class="buttons">
                                        <td></td>
                                        <td>
                                            <button type="submit" class="login_btn" name="action"
                                                value="login">Login</button>
                                            <button type="button" class="signup_btn"
                                                onclick="location.href='register.php'" name="action" value="signup">Sign
                                                Up</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                        <a class="forgot" href="/reset">Forgot your password?</a>
                    </div>

                    <div class="value-info">
                        <!-- Value proposition or other info -->
                    </div>

                    <!-- Indie Box / Donation CTA -->
                    <?php include("../core/components/section_indie_box.php") ?>

                </div>
            </div>

            <div class="row info-area">
                <div class="col info-box">
                    <h3>Retro Social</h3>
                    <p>All the things you missed most about Social Networks are back: Bulletins, Blogs, Forums, and so
                        much more!</p>
                    <p class="link">&raquo; <a href="register.php"
                            title="Join <?= htmlspecialchars(SITE_NAME); ?> Today">Join Today</a></p>
                </div>
                <div class="col info-box">
                    <h3>Privacy Friendly</h3>
                    <p>No algorithms, no tracking, no personalized Ads - just a safe space for you and your friends to
                        hang out online!</p>
                    <p class="link">&raquo; <a href="browse.php"
                            title="Browse <?= htmlspecialchars(SITE_NAME); ?> Profiles">Browse Profiles</a></p>
                </div>
                <div class="col info-box">
                    <h3>Fully Customizable</h3>
                    <p>Featuring custom HTML and CSS to give you all the freedom you need to make your Profile truly
                        <i>your</i> Space on the web!
                    </p>
                    <p class="link">&raquo; <a href="layouts/"
                            title="Discover custom <?= htmlspecialchars(SITE_NAME) ?> Layouts">Discover Layouts</a></p>
                </div>
                <div class="col info-box">
                    <h3>Join Today!</h3>
                    <p>Join your friends on the web or meet some new ones.</p>
                    <p class="link">&raquo; <a href="register.php"
                            title="Sign Up for <?= htmlspecialchars(SITE_NAME); ?>">SignUp Now</a></p>
                </div>
            </div>


            <?php require_once("footer.php") ?>