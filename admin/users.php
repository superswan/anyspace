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

<div class="simple-container">
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
        ?>
              <tr>
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
            <button type="button">Ban</button>
            <button type="button">Change Password</button>
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