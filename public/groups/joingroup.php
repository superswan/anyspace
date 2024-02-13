<?php
require("../../core/conn.php");
require_once("../core/settings.php");

if((int)$_GET['id']) {
    $stmt = $conn->prepare("SELECT * FROM `groups` WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while($row = $result->fetch_assoc()) {
        $groupname = $row['name'];
    }

    $stmt = $conn->prepare("UPDATE users SET currentgroup = ? WHERE username = ?");
    $stmt->bind_param("ss", $groupname, $_SESSION['user']);
    $stmt->execute();
    $stmt->close();

    header("Location: groups.php");
}
?>