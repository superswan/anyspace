<?php
// Include database connection and settings once
require_once("func/conn.php");
require_once("func/settings.php");

function acceptFriend($id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE friends SET status = 'ACCEPTED' WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

function addFriend($id)
{
    global $conn;
    // Your add friend logic here
    if(isset($_GET['id'])) {
        $userId = $_GET['id'];
    
        // Prepare and execute a query to select the user
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $stmt->execute(array($userId));
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if(!$user) exit('User does not exist.');
        
        if($user['username'] == $_SESSION['user']) {
            exit("stop trying to friend yourself");
        } else {
            // Check if the friendship already exists
            $stmt = $conn->prepare("SELECT * FROM `friends` WHERE receiver = ? AND sender = ?");
            $stmt->execute(array($user['username'], $_SESSION['user']));
            if($stmt->fetch(PDO::FETCH_ASSOC)) exit('You are already friends');
    
            // Insert new friendship
            $stmt = $conn->prepare("INSERT INTO friends (sender, receiver) VALUES (?, ?)");
            $stmt->execute(array($_SESSION['user'], $user['username']));
    
            header("Location: friends.php");
        }
    }
}

function revokeFriend($id)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE friends SET status = 'REVOKED' WHERE id = ?");
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
}

function removeFriend($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE friends SET status = 'REMOVED' WHERE id = ?");
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
}

function fetchFriends($pdo, $status, $column, $user)
{
    // Avoid directly inserting variables into SQL to prevent SQL injection
    // IMPORTANT: Validate or sanitize $column since it cannot be parameterized
    $allowedColumns = array('receiver', 'sender');
    if (!in_array($column, $allowedColumns)) {
        throw new InvalidArgumentException("Invalid column name");
    }

    $query = "SELECT * FROM `friends` WHERE `$column` = :user AND status = :status";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':user' => $user, ':status' => $status));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchUserFriends($pdo, $username)
{
    $stmt = $pdo->prepare("SELECT * FROM `friends` WHERE (receiver = :username OR sender = :username) AND status = 'ACCEPTED'");
    $stmt->execute(array(':username' => $username));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}