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
define("SITE_NAME", $siteName);
define("DOMAIN_NAME", $domainName);
define("ADMIN_USER", $adminUser);

// Set TimeZone (Time elapse will not display right if this doesn't match server)
date_default_timezone_set('UTC');
?>

<?php 
// sorry >.< , will eventually combine includes into single file
include("helper.php"); 
?>


