<?php
require("func/conn.php");
require_once("func/settings.php");
require("func/site/user.php");


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$searchResults = array();

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchQuery = "%" . $_GET['q'] . "%";

    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username LIKE :query");
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
        <div>
            <h2>Search Results:</h2>
            <ul>
                <?php foreach ($searchResults as $user): ?>
                    <li>
                        <?php echo htmlspecialchars($user['username']); ?>
                    </li> 
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif (isset($_GET['q'])): ?>
        <p>No results found for "
            <?php echo htmlspecialchars($_GET['q']); ?>".
        </p>
    <?php endif; ?>
</div>

<?php require("footer.php"); ?>