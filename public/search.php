<?php
require("../core/conn.php");
require_once("../core/settings.php");
require("../core/site/user.php");


login_check();

$searchResults = array();

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchQuery = "%" . $_GET['q'] . "%";

    $stmt = $conn->prepare("SELECT id, username, pfp FROM users WHERE username LIKE :query");
    $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
    $stmt->execute();

    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php require("header.php"); ?>

<div class="simple-container">
    <h1>Search</h1>
    <label for="search">
        <p>Search for People on <?= htmlspecialchars(SITE_NAME); ?> by their <b>Name</b>:</p>
    </label>
    <form method="get">
        <input type="text" name="q" id="search" value="" autocomplete="off" autofocus required>
        <button type="submit">Search</button>
    </form>
    <br>
    <?php if (!empty($searchResults)): ?>
        <div class="new-people">
            <div class="top">
                <h4>Search Results:</h4>
            </div>
            <div class="inner">
                <?php foreach ($searchResults as $user) {
                    $profilePicPath = htmlspecialchars('media/pfp/' . $user['pfp']);
                    $profileLink = 'profile.php?id=' . $user['id'];
                    $username = htmlspecialchars($user['username']);

                    echo "<div class='person'>";
                    echo "<a href='{$profileLink}'><p>{$username}</p></a>";
                    echo "<a href='{$profileLink}'><img class='pfp-fallback' src='{$profilePicPath}' alt='Profile Picture' loading='lazy' style='aspect-ratio: 1/1;'></a>";
                    echo "</div>";
                }
                 ?>
            </div>
        </div>
    <?php elseif (isset($_GET['q'])): ?>
        <p>No results found for "
            <?php echo htmlspecialchars($_GET['q']); ?>".
        </p>
    <?php endif; ?>
</div>

<?php require("footer.php"); ?>