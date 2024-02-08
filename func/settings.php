<?php
// Don't delete this
define("DEBUG", true);
session_start();

if (DEBUG == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Site localization settings
$siteName = "AnySpace";
$domainName = "localhost";

define("SITE_NAME", $siteName);
define("DOMAIN_NAME", $domainName);

// Helper Functions (Will eventually get moved)

function validateCSS($validate) {
    $searchVal = array("<", ">", "<?php", "?>", "behavior: url");
    $replaceVal = array("", "", "", "", "");
    $validated = str_replace($searchVal, $replaceVal, $validate);
    return $validated;
}

function getID($user, $connection) {
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(array(':username' => $user));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) return 'error';
    $id = $result[0]['id']; // Assuming username is unique and only one result should be returned
    return $id;
}

function getName($id, $connection) {
    $stmt = $connection->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(array(':id' => $id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) return 'error';
    $name = $result[0]['username']; // Assuming ID is unique and only one result should be returned
    return $name;
}

function getPFP($user, $connection) {
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(array(':username' => $user));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) === 0) return 'error';
    $pfp = $result[0]['pfp']; // Assuming username is unique and only one result should be returned
    return $pfp;
}

// thanks dzhaugasharov https://gist.github.com/afsalrahim/bc8caf497a4b54c5d75d
function replaceBBcodes($text) {
    $text = htmlspecialchars($text);
    // BBcode array
    $find = array(
        '~\[b\](.*?)\[/b\]~s',
        '~\[i\](.*?)\[/i\]~s',
        '~\[u\](.*?)\[/u\]~s',
        '~\[quote\]([^"><]*?)\[/quote\]~s',
        '~\[size=([^"><]*?)\](.*?)\[/size\]~s',
        '~\[color=([^"><]*?)\](.*?)\[/color\]~s',
        '~\[url\]((?:ftp|https?)://[^"><]*?)\[/url\]~s',
        '~\[img\](https?://[^"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
    );
    // HTML tags to replace BBcode
    $replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
        '<span style="text-decoration:underline;">$1</span>',
        '<pre>$1</pre>',
        '<span style="font-size:$1px;">$2</span>',
        '<span style="color:$1;">$2</span>',
        '<a href="$1">$1</a>',
        '<img src="$1" alt="" />'
    );
    // Replacing the BBcodes with corresponding HTML tags
    return preg_replace($find, $replace, $text);
}
?>
