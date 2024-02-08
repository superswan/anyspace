<?php
require("func/conn.php");
require_once("func/settings.php");

/** 
if(isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while($row = $result->fetch_assoc()) {
        $id = $row['id'];
    }

    $stmt = $conn->prepare("SELECT * FROM `comments` WHERE toid = ? AND id = ?");
    $stmt->bind_param("ii", $id, $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while($row = $result->fetch_assoc()) {
        $check = 1;
    }

    if($check == 1) {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: index.php");
}
**/

function addComment($pdo, $toid, $authorId, $text) {
    $stmt = $pdo->prepare("INSERT INTO comments (toid, author, text, date) VALUES (:toid, :author, :text, NOW())");
    $success = $stmt->execute(array(':toid' => $toid, ':author' => $authorId, ':text' => $text));
    return $success;
}

function fetchComments($pdo, $toid, $limit=null)
{
    $query = "SELECT * FROM `comments` WHERE toid = :toid ORDER BY id DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
    }

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':toid', $toid);
    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>