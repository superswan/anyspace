<?php
require("../core/conn.php");
require_once("../core/settings.php");
require("../core/site/user.php");
require("../core/site/edit.php");


login_check();

$userId = $_SESSION['userId'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $status = isset($_POST['category']['status']) ? $_POST['category']['status'] : '';
        $mood = isset($_POST['category']['mood']) ? $_POST['category']['mood'] : '';
        $you = isset($_POST['category']['you']) ? $_POST['category']['you'] : '';
    
        $statusArray = array(
            "status" => $status,
            "mood" => $mood,
            "you" => $you
        );
    
        $jsonStatus = json_encode($statusArray);
        updateUserStatus($userId, $jsonStatus);
    }
}

$statusInfo = fetchUserStatus($userId);

$status = $statusInfo['status'];
$mood = $statusInfo['mood'];
$you = $statusInfo['you'];


?>
<?php require("header.php"); ?>

<div class="row edit-profile">
    <div class="col w-20 left">
        <!-- SIDEBAR CONTENT -->
    </div>
    <div class="col right">
        <h1>Edit Your Status</h1>
        <p>All fields are optional and can be left empty if you want.</p>
        <form method="post" class="ctrl-enter-submit">
            <button type="submit" name="submit">Save All</button>
            <br>
            <label for="category_status">
                <h3>Status:</h3>
            </label>
            <p>What are you doing right now?</p><input type="text" maxlength="65" class="status_input"
                id="category_status" name="category[status]" value="<?= $status ?>">
            <p><b>Examples:</b> <i>reading, chilling, studying, sleeping, ...</i></p><br><label for="category_mood">
                <h3>Mood:</h3>
            </label>
            <p>How are you feeling right now?</p><input type="text" maxlength="65" class="status_input"
                id="category_mood" name="category[mood]" value="<?= $mood ?>">
            <p><b>Examples:</b> <i>busy, bored, happy, sad, ...</i></p><br><label for="category_you">
                <h3>You:</h3>
            </label>
            <p>A few short words about yourself.</p><input type="text" maxlength="65" class="status_input"
                id="category_you" name="category[you]" value="<?= $you ?>">
            <p><b>Examples:</b> <i>Your age, country, ...</i></p><br> <br><br>
            <button type="submit" name="submit">Save All</button>
        </form>
    </div>
</div>


<?php require("footer.php"); ?>