<?php
    $title = "Admin Users Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">Admin Users Page</h1>

  <?php
      require('partials/search.php')
  ?>

  <a  class="btn btn-primary" href="./create_user" >
    Create User
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
        <td>
          <a href="./edit_user?id=<?= $user->id ?>" class="btn btn-primary">Edit</a>
          <?php if($user->is_banned): ?>
            <button type="button" class="btn btn-success unban-User" data-bs-toggle="modal" data-bs-target="#unbanModal" data-id="<?= $user->id ?>">Unban</button>
          <?php else: ?>
            <button type="button" class="btn btn-danger ban-User" data-bs-toggle="modal" data-bs-target="#banModal" data-id="<?= $user->id ?>">Ban</button>
          <?php endif; ?>
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

<div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="ban_user" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="banModalLabel">Ban User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to ban this user?
                  <input type="hidden" name="id" id="ban_user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Ban Book</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unban Modal -->

<div class="modal fade" id="unbanModal" tabindex="-1" aria-labelledby="unbanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="unban_user" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="unbanModalLabel">Unban User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Are you sure you want to unban this user?
                  <input type="hidden" name="id" id="unban_user_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Unban Book</button>
                </div>
            </form>
        </div>
    </div>
</div>

     

<script>
    var banUserModal = document.getElementById('banModal')
    banUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var modalTitle = banUserModal.querySelector('.modal-title')
        var idInput = banUserModal.querySelector('#ban_user_id')
        modalTitle.textContent = 'Ban User'
        idInput.value = id
    })
</script>

<script>
    var unbanUserModal = document.getElementById('unbanModal')
    unbanUserModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var modalTitle = unbanUserModal.querySelector('.modal-title')
        var idInput = unbanUserModal.querySelector('#unban_user_id')
        modalTitle.textContent = 'Unban User'
        idInput.value = id
    })
</script>



<?php require('partials/footer.php') ?>
