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

function fetchComments($pdo, $toid)
{
    $stmt = $pdo->prepare("SELECT * FROM `comments` WHERE toid = :toid ORDER BY id DESC");
    $stmt->execute(array(':toid' => $toid));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>