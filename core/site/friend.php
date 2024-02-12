<?php
require_once("core/conn.php");
require_once("core/settings.php");

function autoAddFriend($newUserId) {
    global $conn;
    $systemUserId = 1; 
    $insertStmt = $conn->prepare("INSERT INTO friends (sender, receiver, status) VALUES (:senderId, :receiverId, 'ACCEPTED')");
    $insertStmt->execute(array(':senderId' => $systemUserId, ':receiverId' => $newUserId));
}
function addFriend($pdo, $senderId, $receiverId) {
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

function fetchUserFriends($userId, $limit=null)
{
    global $conn;
    $query = "SELECT * FROM `friends` WHERE (receiver = :userId OR sender = :userId) AND status = 'ACCEPTED'";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
    }
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);
    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function checkFriend($userId, $targetId) {
    global $conn;
    if ($userId == $targetId) {
        return false;
    }

    $query = "SELECT COUNT(*) FROM friends 
              WHERE ((sender = :userId AND receiver = :targetId) OR (sender = :targetId AND receiver = :userId)) 
              AND status = 'ACCEPTED'";

    try {
        $stmt = $conn->prepare($query);
        $stmt->execute(array(':userId' => $userId, ':targetId' => $targetId));
        $count = $stmt->fetchColumn();

        return $count > 0; // True if a friendship exists, false otherwise
    } catch (PDOException $e) {
        // Handle error, log it, or return false if you prefer to hide the error
        error_log("Error checking friendship: " . $e->getMessage());
        return false; // Assuming false in case of an error
    }
}
