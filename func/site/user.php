<?php
function fetchUsers($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM `users`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchUserInfo($pdo, $userId)
{
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE id = :id");
    $stmt->execute(array(':id' => $userId));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchUserInfoByUsername($pdo, $username) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(array(':username' => $username));
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    return $userInfo;
}


function fetchUserBlogs($pdo, $username)
{
    $stmt = $pdo->prepare("SELECT * FROM `blogs` WHERE author = :author");
    $stmt->execute(array(':author' => $username));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>