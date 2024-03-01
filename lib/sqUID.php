<?php
// sqUID for php
// based on https://raw.githubusercontent.com/argosback/sqUID/master/sqUID.js
$idIncrementor = 999999;

function generateUniqueId($prefix = '', $strlen = 25) {
    global $idIncrementor;

    $newStr = '';
    $chars  = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghiklmnopqrstuvwxyz";

    // Start with a timestamp in milliseconds
    $newStr .= round(microtime(true) * 1000);

    // Add 1 to the incrementor and add on the new number
    $idIncrementor += 1;
    $newStr .= "-" . $idIncrementor . "-";

    // Reset the incrementor if it's getting too large
    if ($idIncrementor === 9999999) {
        $idIncrementor = 999999;
    }

    // Add on a random string of specified length
    for ($i = 0; $i < $strlen; $i++) {
        $newStr .= $chars[rand(0, strlen($chars) - 1)];
    }

    $lastEight = substr($newStr, -8);
    // If there was a prefix, add it to the beginning
    return $prefix ? $prefix . '-' . $lastEight : $lastEight;
}

