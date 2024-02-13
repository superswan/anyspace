<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/bulletin.php");

login_check();

$user = $_SESSION['user'];
$userId = $_SESSION['userId'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    createBulletin($userId, $_POST);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>New Bulletin | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/static/css/normalize.css">
    <link rel="stylesheet" href="/static/css/header.css">
    <link rel="stylesheet" href="/static/css/base.css">
    <link rel="stylesheet" href="/static/css/my.css">
    <link rel="stylesheet" href="/blog/editor/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="/blog/editor/plugins/colors/ui/trumbowyg.colors.min.css">
    <link rel="stylesheet" href="/blog/editor/plugins/emoji/ui/trumbowyg.emoji.min.css">

    <style>
.trumbowyg-toolbar {
    height: auto; 
}
</style>
</head>

<body>
    <div class="master-container">
        <?php require_once("../navbar.php"); ?>
        <main>


<div class="row edit-blog-entry">
  <div class="col w-20 left">
    <div class="edit-info">
      <p>Use the visual WYSIWYG Editor to edit your content.</p>
    </div>
  </div>
  <div class="col right">
    <h1>Create Bulletin</h1>
    <br>
    
    <form method="post" class="ctrl-enter-submit">
      <label for="subject">Subject:</label>
      <input type="text" id="subject" name="subject" autocomplete="off" value="" required>

      <br><br>

      <label for="wysiwyg">Content:</label>
      <div>
        <textarea class="tb_wysiwyg" id="wysiwyg" name="content"></textarea>
      </div>


      <div class="publish">
        <button type="submit" name="submit">
          Post Bulletin        </button>
      </div>
    </form>

    
  </div>
</div>
</main>
<footer>
        <p>
                <a href="https://github.com/superswan/anyspace/superswan/anyspace" target="_blank" rel="noopener">AnySpace Engine</a>
        </p>
        <p> <i>Disclaimer: This project is not affiliated with MySpace&reg; in any way.</i>
        </p>
        <ul class="links">
                <li><a href="about.php">About</a></li>
                <li><a href="rules.php">Rules</a></li>
                <li><a href="https://github.com/superswan/anyspace/superswan/anyspace">Source Code</a></li>
        </ul>
        <p class="copyright">
                <a href="https://github.com/superswan/anyspace/superswan/anyspace/superswan/anyspace">&copy;2024 Copyleft</a>
        </p>
</footer>

<!-- JQuery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>

<!-- WSYIWIG Editor -->
<script src="/blog/editor/trumbowyg.min.js" ></script>

<!-- Editor Plugins and Injection -->
<script src="/blog/editor/plugins/colors/trumbowyg.colors.js"></script>
<script src="/blog/editor/plugins/emoji/trumbowyg.emoji.min.js"></script>
<script src="/blog/editor.js"></script>

</body>

</html>