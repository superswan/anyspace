<?php
// Include database connection and settings once
require_once("func/conn.php");
require_once("func/settings.php");


function addFriend($pdo, $senderId, $receiverId) {
    // Check if the users are trying to friend themselves
    if ($senderId == $receiverId) {
        exit("You cannot friend yourself.");
    }

    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM `friends` WHERE (sender = :senderId AND receiver = :receiverId) OR (sender = :receiverId AND receiver = :senderId)");
    $checkStmt->execute(array(':senderId' => $senderId, ':receiverId' => $receiverId));
    $exists = $checkStmt->fetchColumn() > 0;

    if ($exists) {
        exit('You are already friends or there is a friend request pending');
    }

    $insertStmt = $pdo->prepare("INSERT INTO friends (sender, receiver, status) VALUES (:senderId, :receiverId, 'PENDING')");
    $insertStmt->execute(array(':senderId' => $senderId, ':receiverId' => $receiverId));

    header("Location: requests.php");
}

function acceptFriend($pdo, $senderId, $receiverId) {
    $stmt = $pdo->prepare("UPDATE friends SET status = 'ACCEPTED' WHERE sender = :senderId AND receiver = :receiverId AND status = 'PENDING'");
    $stmt->execute(array(':senderId' => $senderId, ':receiverId' => $receiverId));

    header("Location: requests.php");
}

function revokeFriend($pdo, $senderId, $receiverId) {
    $stmt = $pdo->prepare("DELETE FROM friends WHERE sender = :senderId AND receiver = :receiverId AND status = 'PENDING'");
    $stmt->execute(array(':senderId' => $senderId, ':receiverId' => $receiverId));
}

function removeFriend($pdo, $senderId, $receiverId) {
    $stmt = $pdo->prepare("DELETE FROM friends WHERE (sender = :senderId AND receiver = :receiverId) OR (sender = :receiverId AND receiver = :senderId) AND status = 'ACCEPTED'");
    $stmt->execute(array(':senderId' => $senderId, ':receiverId' => $receiverId));
}


function fetchFriends($pdo, $status, $column, $userId)
{
    $allowedColumns = array('receiver', 'sender');
    if (!in_array($column, $allowedColumns)) {
        throw new InvalidArgumentException("Invalid column name");
    }

    $query = "SELECT * FROM `friends` WHERE `$column` = :userId AND status = :status";
    
    $stmt = $pdo->prepare($query);
    // Execute the statement with the provided user ID and status
    $stmt->execute(array(':userId' => $userId, ':status' => $status));

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchUserFriends($pdo, $username)
{
    $stmt = $pdo->prepare("SELECT * FROM `friends` WHERE (receiver = :username OR sender = :username) AND status = 'ACCEPTED'");
    $stmt->execute(array(':username' => $username));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}