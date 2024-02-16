            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td>
                        <a href="profile.php?id=<?= htmlspecialchars($comment['author']) ?>">
                            <p>
                                <?= htmlspecialchars(fetchName($comment['author'])) ?>
                            </p>
                        </a>
                        <a href="profile.php?id=<?= htmlspecialchars($comment['author']) ?>">
                            <?php
                            $pfpPath = fetchPFP($comment['author']);
                            $pfpPath = $pfpPath ? $pfpPath : 'default.png';
                            ?>
                            <img class="pfp-fallback" src="media/pfp/<?= $pfpPath ?>"
                                alt="<?= htmlspecialchars(fetchName($comment['author'])) ?>'s profile picture" loading="lazy"
                                width="50px">
                        </a>
                    </td>
                    <td>
                        <p><b><time class="">
                                    <?= time_elapsed_string($comment['date']) ?>
                                </time></b></p>
                        <p>
                            <?= htmlspecialchars($comment['text']) ?>
                        </p>
                        <br>
                        <p class="report">
                            <a href="/report?type=comment&id=<?= htmlspecialchars($comment['id']) ?>" rel="nofollow">
                                <img src="/static/icons/flag_red.png" class="icon" aria-hidden="true" loading="lazy" alt="">
                                Report Comment
                            </a>
                        </p>
                        <?php if ($userId == $comment['author'] || $userId == $toid): ?>
                            <a href="deletecomment.php?id=<?= htmlspecialchars($comment['id']) ?>">
                                <button>Delete</button>
                            </a>
                        <?php endif; ?>
                        <a href="addcomment.php?id=<?= $toid ?>&reply=<?= htmlspecialchars($comment['id']) ?>">
                            <button>Add Reply</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>