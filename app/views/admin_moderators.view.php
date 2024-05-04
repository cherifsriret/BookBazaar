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
        <th scope="row"><?=$user->getId() ?></th>
        <td><?= $user->getFirstName() ?></td>
        <td><?= $user->getLastName() ?></td>
        <td><?= $user->getEmail() ?></td>
        <td><?= $user->getPhone() ?></td>
        <td><?= $user->getRole() ?></td>
        <td></td>
        <td>
          <a href="./update_moderator_form?id=<?= $user->getId() ?>" class="btn btn-primary">Edit</a>
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#banModal" data-id="<?= $user->getId() ?>">
            Ban
          </button>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#unbanModal" data-id="<?= $user->getId() ?>">
            Unban
          </button>
        </td>

      
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>



  <!-- Add pagination -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">

      <?php 
      $currentParams = $_GET;
      unset($currentParams['page']);

      foreach ($currentParams as $key => $value) {
        $currentParams[$key] = urlencode($value);
      }

      foreach ($currentParams as $key => $value) {
        $currentParams[$key] = "$key=$value";
      }

      $currentParamsString = implode('&', $currentParams);
      ?>
      <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./admin_users?page=1&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">First</a>
      </li>
      <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./admin_users?page=<?php echo $currentPage - 1; ?>&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">Previous</a>
      </li>

      <?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
        <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
          <a class="page-link" href="./admin_users?page=<?php echo $i; ?>&<?= $currentParamsString ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./admin_users?page=<?php echo $currentPage + 1; ?>&<?= $currentParamsString ?>">Next</a>
      </li>
      <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./admin_users?page=<?php echo $totalPages; ?>&<?= $currentParamsString ?>">Last</a>
      </li>

    </ul>
  </nav>

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
              <a href="./ban_moderator?id=<?= $user->getId() ?>" class="btn btn-danger">Ban</a>
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
              <a href="./unban_moderator?id=<?= $user->getId() ?>" class="btn btn-success">Unban</a>
            </div>
          </div>
        </div>
      </div>


<?php require('partials/footer.php') ?>
