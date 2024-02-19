<?php
// this is meant to be used to set temporary passwords for resets
require_once("../conn.php");
require_once("../../lib/password.php");

function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';
    for ($i = 0, $charactersLength = strlen($characters); $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

$userId = $_REQUEST['userId']; 

$password = generateRandomPassword();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sqlUpdatePassword = "UPDATE `users` SET `password` = ? WHERE `id` = ?";

$stmt = $conn->prepare($sqlUpdatePassword);
$stmt->execute(array($hashedPassword, $userId));

if ($stmt->rowCount() > 0) {
    echo "Password reset successfully for user ID $userId. New password: $password<br>";
} else {
    echo "Failed to reset password for user ID $userId.<br>";
}

?>
