<?php
// used to update users when implemented. keeping for now in case it becomes toggleable feature
require("../conn.php");
require("../settings.php");
function autoAddAllUsersAsFriends($conn, $systemUserId = 1) {
    // Fetch all user IDs except the system user's ID
    $stmt = $conn->prepare("SELECT id FROM users WHERE id != :systemUserId");
    $stmt->bindParam(':systemUserId', $systemUserId, PDO::PARAM_INT);
    $stmt->execute();
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($userIds as $userId) {
        // Automatically create and accept the friendship for each user with the system user
        try {
            $insertStmt = $conn->prepare("INSERT INTO friends (sender, receiver, status) VALUES (:senderId, :receiverId, 'ACCEPTED')");
            $insertStmt->execute(array(':senderId' => $systemUserId, ':receiverId' => $userId));
        } catch (PDOException $e) {
            // Handle the exception, e.g., log it or echo a message
            error_log("Error adding friend relationship: " . $e->getMessage());
            // Optionally, stop the execution or continue based on your requirements
        }
    }

    echo "All users have been successfully added as friends with user ID $systemUserId.";
}

autoAddAllUsersAsFriends($conn, 1);
