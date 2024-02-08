<?php
// Interests system is a little broken at the moment
require("func/conn.php");
$defaultInterests = array(
    "General" => "",
    "Music" => "",
    "Movies" => "",
    "Television" => "",
    "Books" => "",
    "Heroes" => ""
);
$jsonInterests = json_encode($defaultInterests);

try {
    // Assuming $conn is your PDO connection object
    $sql = "UPDATE users SET interests = :interests WHERE interests IS NULL OR interests = ''";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':interests', $jsonInterests, PDO::PARAM_STR);
    $stmt->execute();

    $affectedRows = $stmt->rowCount();
    echo "Updated $affectedRows users with default interests.";
} catch (PDOException $e) {
    die("Error updating users: " . $e->getMessage());
}


echo 'done';
?>
