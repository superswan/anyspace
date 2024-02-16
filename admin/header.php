<!DOCTYPE html>
<html>

<head>
    <title><?= SITE_NAME ?> | Admin Panel</title>
    <link rel="icon" href="static/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="description" content="An Open Source social network">
    <link rel="stylesheet" href="../public/static/css/normalize.css">
    <link rel="stylesheet" href="../public/static/css/header.css">
    <link rel="stylesheet" href="../public/static/css/base.css">
    <link rel="stylesheet" href="../public/static/css/my.css">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url"  content="https://<?= DOMAIN_NAME ?>/">
    <meta property="og:title" content="<?= SITE_NAME ?>">
    <meta property="og:description" content="A brief description of your site.">
    <meta property="og:image" content="https://yourwebsite.com/static/og-image.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://<?= DOMAIN_NAME ?>/">
    <meta name="twitter:title" content="<?= SITE_NAME ?>">
    <meta name="twitter:description" content="<?= SITE_NAME ?> a space for anyone">
    <meta name="twitter:image" content="">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden; 
        }

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
        <?php require_once("navbar.php"); ?>
        <main>