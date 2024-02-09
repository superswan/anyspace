<?php
require("func/conn.php");
require("func/settings.php");
require("lib/password.php");

// Start or resume a session
if (session_id() == '') {
    session_start();
}

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

      
            // Prepare SQL statement for login
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
            $stmt->execute(array($email)); // Execute with parameter for PHP 5.3 compatibility
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user

            // Verify user exists and check password
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username']; 
                $_SESSION['userId'] = $user['id']; 
                header("Location: home.php"); 
                exit;
            } else {
                // Handle login failure
                echo '<p>Login information doesn\'t exist or incorrect password.</p><hr>';
            }
    } 
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="static/css/normalize.css">
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/base.css">
    <link rel="stylesheet" href="static/css/my.css">
</head>

<body>
    <div class="master-container">
        <?php require("navbar.php"); ?>
        <main>
            <div class="row home">
                <div class="col w-60 left">
                    <!-- Cool New People Section -->
                    <div class="new-people cool">
                        <div class="top">
                            <h4>New Users</h4>

                        </div>
                        <div class="inner">
                                <?php
                                $stmt = $conn->prepare("SELECT id, username, pfp FROM `users`");
                                $stmt->execute();

                                // Fetch and display each row
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $profilePicPath = htmlspecialchars('pfp/' . $row['pfp']);
                                    $profileLink = 'profile.php?id=' . $row['id'];
                                    $username = htmlspecialchars($row['username']);

                                    // Display link with profile picture and username
                                    echo "<div class='person'>";
                                    echo "<a href='{$profileLink}'><p>{$username}</p></a>";
                                    echo "<a href='{$profileLink}'><img class='pfp-fallback' src='{$profilePicPath}' alt='Profile Picture' loading='lazy' style='aspect-ratio: 1/1;'>";
                                    echo "</div>";
                                }
                                ?>
                        </div>
                    </div>

                    <div class="music">
                        <!-- Content similar to Cool New People -->
                        <div class="heading">
                            <h4><?= htmlspecialchars(SITE_NAME); ?> Music</h4>
                            <a class="more" href="#">[more music]</a>
                        </div>
                        <div class="inner">
                            <div class="cover">
                                <a href="/topmusic">
                                    <img src="https://i1.sndcdn.com/artworks-Jn90sypuOrP3cv98-6PYYmQ-t500x500.jpg"
                                        alt="cover" loading="lazy">
                                </a>
                            </div>
                            <div class="details">
                                <h4><a href="/topmusic">Rainworld</a></h4>
                                <h5>
                                    BRG Rain </h5>
                                <p>
                                    Check out the new music from #𝔅ℜ𝔊 Rain: <i>Rainworld</i>!
                                </p>
                                <p><b>&raquo; <a href="#">Listen Now</a></b></p>
                            </div>
                        </div>
                    </div>

                    <!-- Announcements Section -->
                    <div class="specials">
                        <div class="heading">
                            <h4><?= htmlspecialchars($siteName) ?> Announcements</h4>
                        </div>
                        <div class="inner">
                            <div class="image">
                                <a href="https://store.remilia.org/">
                                    <img src="https://store.remilia.org/cdn/shop/files/2_1_180x.gif" alt="Merchandise Photo"
                                        loading="lazy">
                                </a>
                            </div>
                            <div class="details" lang="en">
                                <h4><a href="https://store.remilia.org/">REMILIA Merchandise</a></h4>
                                <p><i>Now available!</i> Support REMILIA by buying a high-quality Shirt, Hoodie,
                                    or hat! <span class="m-hide">Check out the full Collection on <a
                                            href="https://store.remilia.org">store.remilia.org</a>!</span></p>
                                <p><b>&raquo; <a href="https://store.remilia.org/">Shop Now!</a></b></p>
                            </div>
                        </div>
                    </div>
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
                                            <button type="submit" class="signup_btn" name="action" value="signup">Sign
                                                Up!</button>
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
                    <div class="indie-box">
                        <p>
                            <?= htmlspecialchars(SITE_NAME); ?> is an open source social network. Check out the code and host your own instance!
                        </p>
                        <p>
                            <a href="https://github.com" class="more-details">[more details]</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row info-area">
                <div class="col info-box">
                    <h3>Retro Social</h3>
                    <p>All the things you missed most about Social Networks are back: Bulletins, Blogs, Forums, and so
                        much more!</p>
                    <p class="link">&raquo; <a href="/signup" title="Join <?= htmlspecialchars(SITE_NAME); ?> Today">Join Today</a></p>
                </div>
                <div class="col info-box">
                    <h3>Privacy Friendly</h3>
                    <p>No algorithms, no tracking, no personalized Ads - just a safe space for you and your friends to
                        hang out online!</p>
                    <p class="link">&raquo; <a href="browse.php" title="Browse <?= htmlspecialchars(SITE_NAME); ?> Profiles">Browse Profiles</a></p>
                </div>
                <div class="col info-box">
                    <h3>Fully Customizable</h3>
                    <p>Featuring custom HTML and CSS to give you all the freedom you need to make your Profile truly
                        <i>your</i> Space on the web!
                    </p>
                    <p class="link">&raquo; <a href="layouts.php"
                            title="Discover custom <?= htmlspecialchars(SITE_NAME) ?> Layouts">Discover Layouts</a></p>
                </div>
                <div class="col info-box">
                    <h3>Join Today!</h3>
                    <p>Join your friends on the web or meet some new ones.</p>
                    <p class="link">&raquo; <a href="register.php" title="Sign Up for <?= htmlspecialchars(SITE_NAME); ?>">SignUp Now</a></p>
                </div>
            </div>


<?php require_once("footer.php") ?>