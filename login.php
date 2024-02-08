<?php
require("func/conn.php");
require_once("func/settings.php");
require("lib/password.php"); // compatibility library for PHP 5.3

// Start or resume a session
if (session_id() == '') {
    session_start();
}

// Process login 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'login') {
        // Sanitize input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if ($_POST['action'] == 'login') {
            // Prepare SQL statement for login
            $stmt = $conn->prepare("SELECT username, password FROM users WHERE email = ?");
            $stmt->execute(array($email));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                header("Location: home.php");
                exit;
            } else {
                echo '<p>Login information doesn\'t exist or incorrect password.</p><hr>';
            }

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
            <div class="center-container">
                <div class="box standalone">
                    <!-- Login/Signup Form -->
                    <h4>Member Login/Signup</h4>
                    <form action="" method="post" name="theForm" id="theForm">
                        <input name="client_id" type="hidden" value="web">
                        <table>
                            <tbody>
                                <tr class="email">
                                    <td class="label"><label for="email">E-Mail:</label></td>
                                    <td class="input"><input type="email" name="email" id="email" autocomplete="email"
                                            value="" required></td>
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
                                       <a href="register.php"> <button class="signup_btn" name="action" value="signup">Sign
                                            Up!</button></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <a class="forgot" href="/reset">Forgot your password?</a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>