<?php
require("../conn.php");
require("../settings.php");
function autoAddAllUsersAsFriends($conn, $systemUserId = 1) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE id != :systemUserId");
    $stmt->bindParam(':systemUserId', $systemUserId, PDO::PARAM_INT);
    $stmt->execute();
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($userIds as $userId) {
        try {
            $insertStmt = $conn->prepare("INSERT INTO friends (sender, receiver, status) VALUES (:senderId, :receiverId, 'ACCEPTED')");
            $insertStmt->execute(array(':senderId' => $systemUserId, ':receiverId' => $userId));
        } catch (PDOException $e) {
            error_log("Error adding friend relationship: " . $e->getMessage());
        }
    }

    echo "All users have been successfully added as friends with user ID $systemUserId.";
}

autoAddAllUsersAsFriends($conn, 1);
