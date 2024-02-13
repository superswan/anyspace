<?php
require("../../core/conn.php");
require_once("../../core/settings.php");
require_once("../../core/site/user.php");
require_once("../../core/site/blog.php");
require_once("../../core/site/comment.php");

login_check();

$blogEntries = fetchAllBlogEntries();
$highlightedEntry = 1;


  ?>
<?php require("blog-header.php"); ?>

<div class="row blog-category">
  <div class="col w-20 left">
    <div class="category-list">
      <b>View:</b>
      <ul>
        <!--
        <li><b><a href="/"><img src="/static/icons/asterisk_yellow.png" class="icon" aria-hidden="true" loading="lazy"
                alt=""> Top Entries</a></b></li>
-->
        <li><a href="/recent"><img src="/static/icons/clock.png" class="icon" aria-hidden="true" loading="lazy" alt="">
            <b>Recent Entries</b></a></li>
            <!--
        <li><a href="/subscriptions"><img src="/static/icons/world.png" class="icon" aria-hidden="true" loading="lazy"
              alt=""> Subscriptions</a></li>
-->
      </ul>
      <b>Categories:</b>
      <ul>
        <li><a href="/category?id=24">Art</a></li>
        <li><a href="/category?id=16">Automotive</a></li>
        <li><a href="/category?id=19">Fashion</a></li>
        <li><a href="/category?id=19">Financial</a></li>
        <li><a href="/category?id=3">Food</a></li>
        <li><a href="/category?id=8">Games</a></li>
        <li><a href="/category?id=14">Life</a></li>
        <li><a href="/category?id=27">Literature</a></li>
        <li><a href="/category?id=6">Math & Science</a></li>
        <li><a href="/category?id=6">Movies & TV</a></li>
        <li><a href="/category?id=15">Music</a></li>
        <li><a href="/category?id=26">Paranormal</a></li>
        <li><a href="/category?id=7">Politics</a></li>
        <li><a href="/category?id=11">Philosophy</a></li>
        <li><a href="/category?id=20">Romance</a></li>
        <li><a href="/category?id=4">Sports</a></li>
        <li><a href="/category?id=12">Technology</a></li>
        <li><a href="/category?id=18">Travel</a></li>
      </ul>
    </div>
  </div>
  <div class="col right">
    <h1>Blogs</h1>
    <div class="blog-preview">
      <h3>[<a href="user.php?id=<?= $_SESSION['userId'] ?>">View Your Blog</a>]</h3>
      <h3>[<a href="newpost.php">Create a new Blog Entry</a>]</h3>
      <!--
      <div class="blog-entries">
        <div class="entry">
          <div class="inner">
            <h3 class="title">
              <a href="/entry?id=$highlightedEntry"></a>
            </h3>
            <p>
              <a href="/entry?id=$highlightedEntry ">&raquo; Read Blog Entry</a>
            </p>
          </div>
        </div>
      </div>
      -->
      <hr>
      <h3>Latest Blog Entries</h3>
      <div class="blog-entries">
        <?php foreach ($blogEntries as $entry): ?>
          <?php $countTotalComments = count(fetchBlogComments($entry['id'])); ?>
          <div class="entry">
             <p class="publish-date">
              <time class="ago"><?= time_elapsed_string($entry['date']) ?></time>
              &mdash; by <a href="user.php?id=<?= $entry['author'] ?>"><?= fetchName($entry['author']) ?></a>
              &mdash; <a href="comments.php?id=<?= $entry['id'] ?>"><?= $countTotalComments ?> Comments</a><!--&mdash; 0 Kudos -->           </p>
            <div class="inner">
              <h3 class="title">
                <a href="entry.php?id=<?= htmlspecialchars($entry['id']) ?>">
                  <?= htmlspecialchars($entry['title']) ?>
                </a>
              </h3>
              <p>
                <?php
                $maxLength = 280;
                $previewText = $entry['text'];
                if (mb_strlen($previewText) > $maxLength) {
                  $previewText = mb_substr($previewText, 0, $maxLength) . '...';
                }
                echo nl2br($previewText); ?>
                <a href="entry.php?id=<?= htmlspecialchars($entry['id']) ?>">&raquo; Continue Reading</a>
              </p>
              <a href="entry.php?id=<?= htmlspecialchars($entry['id']) ?>">&raquo; View Blog Entry</a>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if (empty($blogEntries)): ?>
          <p>No blog entries found.</p>
        <?php endif; ?>
      </div>
    </div>
    <div class="pagination">
      <a class="next" rel="next" href="/?page=2">
        <button>
          Next Page
        </button>
      </a>
    </div>
  </div>
</div>



<?php require("../footer.php"); ?>