<br><br>
<div class="comment-replies">
<?php foreach ($replies as $reply): ?>
    <div class="comment-reply">
        <p><?= htmlspecialchars($reply['text']) ?></p>
        <p>
            <small>
                by <a href="/profile.php?id=<?= htmlspecialchars($reply['author']) ?>"><b><?= htmlspecialchars(fetchName($reply['author'])) ?></b></a>;
                <time class="ago"><?= time_elapsed_string($reply['date']) ?></time>;
                <a href="#/report?type=comment&id=<?= htmlspecialchars($reply['id']) ?>" rel="nofollow">
                    Report
                </a>
            </small>
        </p>
    </div>
<?php endforeach; ?>
</div>