<?php
function fetchUsers()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `users`");
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

function fetchUserPassword($userId)
{
    global $conn;
    $stmt = $conn->prepare("SELECT password FROM `users` WHERE id = :id");
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
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) return 'error';
    $name = $result[0]['username']; 
    return $name;
}

function fetchEmail($id) {
    global $conn; // Use the globally defined connection
    $stmt = $conn->prepare("SELECT email FROM users WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) return 'error';
    $name = $result[0]['email']; 
    return $name;
}

function fetchPFP($id) {
    global $conn; // Use the globally defined connection
    $stmt = $conn->prepare("SELECT pfp FROM users WHERE id = :id");
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

function addFavorite($userId, $favoriteId) {
    global $conn;
    // Fetch the current favorites JSON string
    $query = "SELECT favorites FROM favorites WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute(array($userId));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentFavorites = $row ? json_decode($row['favorites'], true) : array();

    $currentFavorites[] = $favoriteId;

    $updatedFavorites = json_encode($currentFavorites);

    $query = "INSERT INTO favorites (user_id, favorites) VALUES (?, ?)
              ON DUPLICATE KEY UPDATE favorites = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute(array($userId, $updatedFavorites, $updatedFavorites));
}

function fetchFavorites($userId) {
    global $conn;
    $query = "SELECT favorites FROM favorites WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute(array($userId));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['favorites'] : ''; // Return the JSON string directly
}

function changePassword($userId, $hashedPassword) {
    global $conn; 
    $stmt = $conn->prepare("UPDATE users SET password = :hashedPassword WHERE id = :userId");
    $stmt->execute(array(':hashedPassword' => $hashedPassword, ':userId' => $userId)); 

}

// Should probably get moved, no idea where to put it though
function printPerson($userId) {
    $username = fetchName($userId);
    $profilePicPath = fetchPFP($userId);

    $profilePicPath = htmlspecialchars('media/pfp/' . $profilePicPath);
    $profileLink = 'profile.php?id=' . $userId;
    $username = htmlspecialchars($username);

    echo "<div class='person'>";
    echo "<a href='{$profileLink}'><p>{$username}</p></a>";
    echo "<a href='{$profileLink}'><img class='pfp-fallback' src='{$profilePicPath}' alt='Profile Picture' loading='lazy' style='width: 100%; max-height: 95px; aspect-ratio: 1/1;'></a>";
    echo "</div>";
}





?>