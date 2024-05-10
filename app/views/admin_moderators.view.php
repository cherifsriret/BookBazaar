<?php
    $title = "Admin Moderators Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">Admin Moderators Page</h1>

  <?php
      require('partials/search.php')
  ?>

  <a  class="btn btn-primary" href="./add_moderator_form" >
    Add Moderator
  </a>


  <table class="table mt-5">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Email Name</th>
        <th scope="col">Phone</th>
        <th scope="col">Role</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user): ?>
      <tr>
        <th scope="row"><?=$user->id ?></th>
        <td><?= $user->first_name ?></td>
        <td><?= $user->last_name ?></td>
        <td><?= $user->email ?></td>
        <td><?= $user->phone ?></td>
        <td><?= $user->role ?></td>
        <td></td>
        <td>
          <a href="./update_moderator_form?id=<?= $user->id ?>" class="btn btn-primary">Edit</a>
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#banModal" data-id="<?= $user->id ?>">
            Ban
          </button>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#unbanModal" data-id="<?= $user->id ?>">
            Unban
          </button>
        </td>

      
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Add pagination -->
  <?php require('partials/pagination.php') ?>

</main>


<!-- Modal -->
  <!-- Ban Modal -->
  <div class="modal fade" id="banModal" tabindex="-1" role="dialog" aria-labelledby="banModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="banModalLabel">Ban Moderator</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to ban this moderator?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <a href="./ban_moderator?id=<?= $user->id ?>" class="btn btn-danger">Ban</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Unban Modal -->
      <div class="modal fade" id="unbanModal" tabindex="-1" role="dialog" aria-labelledby="unbanModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="unbanModalLabel">Unban Moderator</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to unban this moderator?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <a href="./unban_moderator?id=<?= $user->id ?>" class="btn btn-success">Unban</a>
            </div>
          </div>
        </div>
      </div>


<?php require('partials/footer.php') ?>
