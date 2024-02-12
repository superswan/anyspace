<?php
require_once("core/conn.php"); 
require_once("lib/sqUID.php"); // php sqUID implementation. generalize long or stupid filenames

function updateInterests($userId, $interests) {
    global $conn;
    $jsonInterests = json_encode($interests);
    $stmt = $conn->prepare("UPDATE users SET interests = ? WHERE id = ?");
    $stmt->execute(array($jsonInterests, $userId));
}

function updateBio($userId, $bio) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $stmt->execute(array($bio, $userId));
}

function updateUserStatus($userId, $jsonStatusInfo) {
    global $conn;
    try {
        $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->execute(array($jsonStatusInfo, $userId));

        echo "<p>Status successfully updated!</p>";
    } catch (PDOException $e) {
        echo "<p>Error updating status: " . $e->getMessage() . "</p>";
    }
}

function updateCSS($userId, $css) {
    global $conn;
    //$css = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '$1', $css);
    $stmt = $conn->prepare("UPDATE users SET css = ? WHERE id = ?");
    $stmt->execute(array($css, $userId));
}

function uploadFile($userId, $file, $targetDir, $validTypes) {
    global $conn;

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file: " . $file['error'];
        return;
    }

    $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($fileType, $validTypes)) {
        error_log('Unsupported file type: ' . $fileType);
        echo 'Unsupported file type: ' . $fileType;
        return;
    }

    $prefix = $targetDir == "pfp/" ? "pfp" : "mus";
    $uniqueId = generateUniqueId($prefix);
    $newFileName = $uniqueId . "." . $fileType;
    $targetFile = $targetDir . $newFileName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        $column = $targetDir == "pfp/" ? "pfp" : "music";
        $stmt = $conn->prepare("UPDATE users SET $column = ? WHERE id = ?");
        $stmt->execute(array($newFileName, $userId));
        $_SESSION['uploadStatus'] = 'File uploaded successfully.';
        echo 'File uploaded successfully.<hr>';
        error_log('Uploaded file: ' . $newFileName . ' Orig: ' . $file['name'] . ' User: ' . fetchName($userId) . '(' . $userId . ')');
        } else {
            error_log('Failed to move uploaded file: ' . $file["name"]);
            echo 'There was an error uploading your file.<hr>';
        }
}

