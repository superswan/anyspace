<?php
function fetchUsers($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM `users`");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchUserInfo($userId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE id = :id");
    $stmt->execute(array(':id' => $userId));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchUserBlogs($pdo, $username)
{
    $stmt = $pdo->prepare("SELECT * FROM `blogs` WHERE author = :author");
    $stmt->execute(array(':author' => $username));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// attribute specific functions
function fetchName($id) {
    global $conn; // Use the globally defined connection
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) return 'error';
    $name = $result[0]['username']; 
    return $name;
}

function fetchPFP($id) {
    global $conn; // Use the globally defined connection
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) return 'error';
    $pfp = $result[0]['pfp']; 
    return $pfp;
}

function fetchUserStatus($id) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && !empty($result['status'])) {
            return json_decode($result['status'], true);
        } else {
            return null;
        }
    } catch (PDOException $e) {
        error_log('Fetch user status failed: ' . $e->getMessage());
        return null;
    }
}




?>