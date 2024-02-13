<?php
require_once("friend.php");
function createBulletin($authorId, $postContent) 
{
    global $conn;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($postContent['submit'])) {
        $title = isset($postContent['subject']) ? $postContent['subject'] : '';
        $text = isset($postContent['content']) ? $postContent['content'] : '';
        $author = $authorId;
        $date = date('Y-m-d H:i:s');

        $title = strip_tags($title);
        $text = strip_tags($text);

        try {
            $stmt = $conn->prepare("INSERT INTO bulletins (title, text, author, date) VALUES (?, ?, ?, ?)");

            $stmt->bindParam(1, $title, PDO::PARAM_STR);
            $stmt->bindParam(2, $text, PDO::PARAM_STR);
            $stmt->bindParam(3, $author, PDO::PARAM_INT);
            $stmt->bindParam(4, $date, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $bulletinId = $conn->lastInsertId();
                echo "<p>Success! Your bulletin was posted successfully!</p>";
                header("Location: bulletin.php?id=" . $bulletinId);
            } else {
                echo "<p>There was a problem posting your bulletin :(</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}

function deleteBulletin($entryId, $authorId) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM bulletins WHERE id = ? AND author = ?");
        
        $stmt->bindParam(1, $entryId, PDO::PARAM_INT);
        $stmt->bindParam(2, $authorId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p>Bulletin successfully deleted!</p>";
        } else {
            echo "<p>There was a problem deleting your bulletin.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}

function fetchAllBulletins($limit=null) {
    global $conn;
    $query = "SELECT * FROM `bulletins` ORDER BY date DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
    } 
    $stmt = $conn->prepare($query);

    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchAllFriendBulletins($userId, $limit=null) {
    global $conn;

    $friendIds = array();
    $friends = fetchUserFriends($userId);
    foreach ($friends as $friend) {
        if ($friend['sender'] == $userId) {
            $friendIds[] = $friend['receiver']; // If the user is the sender, add the receiver ID
        } else {
            $friendIds[] = $friend['sender']; // If the user is the receiver, add the sender ID
        }
    }
    $friendIds[] = $userId; 
    
    $query = "SELECT * FROM `bulletins` WHERE `author` IN (" . implode(",", $friendIds) . ") ORDER BY `date` DESC";

    if ($limit !== null) {
        $query .= " LIMIT :limit";
    }

    $stmt = $conn->prepare($query);

    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchBulletinByAuthor($authorId, $limit=null)
{
    global $conn;
    $query = "SELECT * FROM `bulletins` WHERE author = :authorId ORDER BY id DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
    }

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':authorId', $authorId);
    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchBulletin($entryId)
{
    global $conn;
    $query = "SELECT * FROM `bulletins` WHERE id = :entryId";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':entryId', $entryId);


    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}