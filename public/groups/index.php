<?php
require("../../core/conn.php");
require("../../core/settings.php");
login_check();

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= SITE_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/normalize.css">
    <link rel="stylesheet" href="../static/css/header.css">
    <link rel="stylesheet" href="../static/css/base.css">
    <link rel="stylesheet" href="../static/css/my.css">
        <style>
        @media screen and (max-width: 768px) {
            .row.home {
                display: flex;
                flex-direction: column;
            }

            .col {
                width: 100%;
            }

            .col.right {
                width: 60%);
                margin: 0 auto; 
            }

             .col.w-60 {
                width: 100%;
            }

            .master-container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="master-container">
        <?php require_once("../navbar.php"); ?>
        <main>
<div class="simple-container">
    <h1>Coming Soon!</h1>


</div>

<?php require("../footer.php"); ?>