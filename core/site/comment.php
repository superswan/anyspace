<?php

function addComment($toid, $authorId, $text, $parentId = null) {
    global $conn;
    $encodedText = strip_tags($text);
    $stmt = $conn->prepare("INSERT INTO comments (toid, author, text, date, parent_id) VALUES (:toid, :author, :text, NOW(), :parent_id)");

    $params = array(
        ':toid' => $toid, 
        ':author' => $authorId, 
        ':text' => $encodedText, 
        ':parent_id' => $parentId
    );

    if ($parentId === null) {
        $params[':parent_id'] = 0; // Set to 0 if parentId is null
    }

    $success = $stmt->execute($params);

    return $success;
}

function addBlogComment($toid, $authorId, $text, $parentId = null) {
    global $conn;
    $encodedText = strip_tags($text);
    $stmt = $conn->prepare("INSERT INTO blogcomments (toid, author, text, date, parent_id) VALUES (:toid, :author, :text, NOW(), :parent_id)");
    
    $params = array(
        ':toid' => $toid, 
        ':author' => $authorId, 
        ':text' => $encodedText, 
        ':parent_id' => $parentId
    );

    if ($parentId === null) {
        $params[':parent_id'] = 0; // Set to 0 if parentId is null
    }

    $success = $stmt->execute($params);
    return $success;
}

function addBulletinComment($toid, $authorId, $text, $parentId = null) {
    global $conn;
    $encodedText = strip_tags($text);
    $stmt = $conn->prepare("INSERT INTO bulletincomments (toid, author, text, date, parent_id) VALUES (:toid, :author, :text, NOW(), :parent_id)");
    $params = array(
        ':toid' => $toid, 
        ':author' => $authorId, 
        ':text' => $encodedText, 
        ':parent_id' => $parentId
    );

    if ($parentId === null) {
        $params[':parent_id'] = 0; // Set to 0 if parentId is null
    }
    
    $success = $stmt->execute($params);
    return $success;
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
    $query = "SELECT * FROM `comments` WHERE toid = :toid AND parent_id = 0 ORDER BY id DESC";
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
    $query = "SELECT * FROM `blogcomments` WHERE toid = :toid AND parent_id = 0 ORDER BY id DESC";
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

function fetchBulletinComment($commentId)
{
    global $conn;
    $query = "SELECT * FROM `bulletincomments` WHERE id = :id";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':id', $commentId);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchBulletinComments($toid, $limit=null)
{
    global $conn;
    $query = "SELECT * FROM `bulletincomments` WHERE toid = :toid AND parent_id = 0 ORDER BY id DESC";
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

function fetchCommentReplies($commentId, $type)
{
    global $conn;

    // comment types have separate tables, other functions can and probably will be consilidated in this form 
    $table = '';
    switch ($type) {
        case 'blog':
            $table = 'blogcomments';
            break;
        case 'bulletin':
            $table = 'bulletincomments';
            break;
        default:
            $table = 'comments';
    }

    $query = "SELECT * FROM `$table` WHERE parent_id = :parentid ORDER BY date DESC";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':parentid', $commentId);

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

function deleteBlogComment($commentId, $authorId) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM blogcomments WHERE id = ? AND author = ?");
        
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

function deleteBulletinComment($commentId, $authorId) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM bulletincomments WHERE id = ? AND author = ?");
        
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