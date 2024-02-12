<?php

function createBlogEntry($authorId, $postContent) 
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
            $stmt = $conn->prepare("INSERT INTO blogs (title, text, author, date) VALUES (?, ?, ?, ?)");

            $stmt->bindParam(1, $title, PDO::PARAM_STR);
            $stmt->bindParam(2, $text, PDO::PARAM_STR);
            $stmt->bindParam(3, $author, PDO::PARAM_INT);
            $stmt->bindParam(4, $date, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "<p>Blog entry successfully published!</p>";
                header("Location: user.php?id=" . $authorId);
            } else {
                echo "<p>There was a problem posting your entry :(</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}

function updateBlogEntry($entryId, $authorId, $postContent) {
    global $conn;
    if (isset($postContent['submit'])) {
        // Retrieve form data
        $title = isset($postContent['subject']) ? $postContent['subject'] : '';
        $text = isset($postContent['content']) ? $postContent['content'] : '';
        $date = date('Y-m-d H:i:s'); 

        $title = strip_tags($title);
        $text = strip_tags($text);

        try {
            $stmt = $conn->prepare("UPDATE blogs SET title = ?, text = ?, date = ? WHERE id = ? AND author = ?");
            
            $stmt->bindParam(1, $title, PDO::PARAM_STR);
            $stmt->bindParam(2, $text, PDO::PARAM_STR);
            $stmt->bindParam(3, $date, PDO::PARAM_STR);
            $stmt->bindParam(4, $entryId, PDO::PARAM_INT);
            $stmt->bindParam(5, $authorId, PDO::PARAM_INT); 

            if ($stmt->execute()) {
                echo "<p>Blog entry successfully updated!</p>";
            } else {
                echo "<p>There was a problem updating your entry :(</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}

function deleteBlogEntry($entryId, $authorId) {
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ? AND author = ?");
        
        $stmt->bindParam(1, $entryId, PDO::PARAM_INT);
        $stmt->bindParam(2, $authorId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p>Blog entry successfully deleted!</p>";
        } else {
            echo "<p>There was a problem deleting your entry.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}

function fetchAllBlogEntries($limit=null) {
    global $conn;
    $query = "SELECT * FROM `blogs` ORDER BY date DESC";
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
function fetchBlogEntries($authorId, $limit=null)
{
    global $conn;
    $query = "SELECT * FROM `blogs` WHERE author = :authorId ORDER BY id DESC";
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

function fetchBlogEntry($entryId)
{
    global $conn;
    $query = "SELECT * FROM `blogs` WHERE id = :entryId";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(':entryId', $entryId);


    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}