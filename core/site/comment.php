<?php

function addComment($toid, $authorId, $text) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO comments (toid, author, text, date) VALUES (:toid, :author, :text, NOW())");
    $success = $stmt->execute(array(':toid' => $toid, ':author' => $authorId, ':text' => $text));
    return $success;
}

function addBlogComment($toid, $authorId, $text) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO blogcomments (toid, author, text, date) VALUES (:toid, :author, :text, NOW())");
    $success = $stmt->execute(array(':toid' => $toid, ':author' => $authorId, ':text' => $text));
    return $success;
}

function addBulletinComment($toid, $authorId, $text) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO bulletincomments (toid, author, text, date) VALUES (:toid, :author, :text, NOW())");
    $success = $stmt->execute(array(':toid' => $toid, ':author' => $authorId, ':text' => $text));
    return $success;
}

function getCommentAuthor($commentId)
{
    global $conn;
    $query = "SELECT author FROM `comments` WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':id', $commentId);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function fetchComment($commentId)
{
    global $conn;
    $query = "SELECT * FROM `comments` WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':id', $commentId);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchComments($toid, $limit=null)
{
    global $conn;
    $query = "SELECT * FROM `comments` WHERE toid = :toid ORDER BY id DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
    }

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':toid', $toid);
    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchBlogComment($commentId)
{
    global $conn;
    $query = "SELECT * FROM `blogcomments` WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':id', $commentId);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchBlogComments($toid, $limit=null)
{
    global $conn;
    $query = "SELECT * FROM `blogcomments` WHERE toid = :toid ORDER BY id DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
    }

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':toid', $toid);
    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchBulletinComments($toid, $limit=null)
{
    global $conn;
    $query = "SELECT * FROM `bulletincomments` WHERE toid = :toid ORDER BY id DESC";
    if ($limit !== null) {
        $query .= " LIMIT :limit";
    }

    $stmt = $conn->prepare($query);

    $stmt->bindParam(':toid', $toid);
    if ($limit !== null) {
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function deleteComment($commentId, $authorId) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id = ? AND author = ?");
        
        $stmt->bindParam(1, $commentId, PDO::PARAM_INT);
        $stmt->bindParam(2, $authorId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p>Comment successfully deleted!</p>";
        } else {
            echo "<p>There was a problem deleting your comment.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}