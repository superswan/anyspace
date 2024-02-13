<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/user.php");
require_once("../core/site/bulletin.php");
require_once("../core/site/comment.php");

login_check();

$userId = $_SESSION['userId'];
$bulletins = fetchAllFriendBulletins($userId);
$highlightedEntry = 1;

?>
<?php require("bulletins-header.php"); ?>

<div class="simple-container">
  <h1>Bulletin Board</h1>

  <h3>[<a href="userbulletins.php?id=<?= $userId ?>">View Your Bulletins</a>]</h3>
  <h3>[<a href="createbulletin.php">Post a new Bulletin</a>]</h3>

  <p>Here you can view all Bulletins posted by your Friends. Bulletins have a limited lifespan between 1 and 10 days, after which they will be permanently gone.</p>
  <?php if (!empty($bulletins)): ?>
  <table class="bulletin-table">
    <thead>
      <tr>
        <th scope="col">From</th>
        <th scope="col" class="time-col">Time</th>
        <th scope="col">Subject</th>
        <th scope="col" class="comment-col">Comments</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bulletins as $entry): ?>
                <?php $countTotalComments = count(fetchBulletinComments($entry['id'])); ?>
              <tr>
          <td class="user-info ">
            <a href="/profile.php?id=<?= $entry['author'] ?>">
              <p><?= fetchName($entry['author']) ?></p>
            </a>
            <a href="/profile.php?id=<?= $entry['author'] ?>">
              <img class="pfp-fallback" src="/pfp/<?= fetchPFP($entry['author']) ?>" alt="profile picture" loading="lazy">
            </a>
          </td>
          <td class="time-col">
            <time class="ago"><?= time_elapsed_string($entry['date']) ?></time>
          </td>
          <td class="subject">
            <a href="bulletin.php?id=<?= $entry['id'] ?>">
              <b><?= $entry['title'] ?><b>
            </a>
          </td>
          <td class="comment-col">
            <a href="bulletincomments.php?id=<?= $entry['id'] ?>"><?= $countTotalComments ?> Comments</a> </td>
        </tr>
      <?php endforeach; ?>


          </tbody>
  </table>
    <div class="pagination">
      </div>
      <?php else: ?>
      <p> No bulletins have been posted... (yet) </p>
      <?php endif; ?>
</div>



<?php require("../footer.php"); ?>