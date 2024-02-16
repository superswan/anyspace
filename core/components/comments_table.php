<?php if (empty($comments)): ?>
    <p>No comments yet.</p>
<?php else: ?>
    <table class="comments-table" cellspacing="0" cellpadding="3" bordercolor="ffffff" border="1">
        <tbody>
            <?php include("comments_block.php") ?>
        </tbody>
    </table>
<?php endif; ?>