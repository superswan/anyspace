<?php
require("../core/conn.php");
require_once("../core/settings.php");
require_once("../core/site/user.php");

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

require("../core/config.php");

$users = fetchUsers();
?>


<?php require("header.php"); ?>

<style>
.simple-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.bulletin-table {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

@media screen and (max-width: 768px) {
    .bulletin-table {
        font-size: 14px;
    }
}
</style>

<div class="simple-container">
    <?php if (isset($actionMessage)): ?>
        <div class="alert"><?php echo $actionMessage; ?></div>
    <?php endif; ?>
    <div class="row edit-profile">
    <!--
    <div class="col w-20 left">
    </div>
    -->
    <div class="col right">
        <h1>Manage Users</h1>
        <p>Ban, Promote, Reset Password, etc.</p>

        <table class="bulletin-table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Date Created</th>
        <th scope="col">Modify</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <?php
            $userId = $user['id'];
            $username = $user['username'];
            $email = $user['email'];
            $dateCreated = $user['date'];
            $isBanned = isset($user['is_banned']) && $user['is_banned'] == 1;
        ?>
              <tr<?php echo $isBanned ? ' class="banned"' : ''; ?>>
         <!-- USED ID -->
          <td>
              <p><?= $userId ?></p>

          </td>
         <!-- Username -->
          <td>
            <a href="../public/profile.php?id=<?= $userId ?>">
            <?= $username ?>
      </a>
          </td>
         <!-- Email -->
          <td>
              <p><?= $email ?><p>
          </td>
         <!--Date Created -->
         <td class="time-col">
            <time class="ago"><?= time_elapsed_string($user['date']) ?></time>
          </td>
          <td> 
            <form method="post" action="">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <?php if (!$isBanned): ?>
                    <button type="submit" name="ban_user">Ban</button>
                <?php else: ?>
                    <button type="submit" name="unban_user">Unban</button>
                <?php endif; ?>
            </form>
            <a href="modify_user.php?id=<?php echo $userId; ?>">
              <button type="button">Modify</button>
            </a>
          </td>

        </tr>
      <?php endforeach; ?>


          </tbody>
  </table>
    <div class="pagination">
      </div>
</div>

    </div>
</div>
</div>

<?php require("../public/footer.php"); ?>