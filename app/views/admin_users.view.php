<?php
    $title = "Admin Users Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">Admin Users Page</h1>

  <?php
      require('partials/search.php')
  ?>

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
          <a href="./user_edit?id=<?= $user->id ?>" class="btn btn-primary">Edit</a>
          <a href="./user_delete?id=<?= $user->id ?>" class="btn btn-danger">Delete</a>
        </td>

      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Add pagination -->
  <?php require('partials/pagination.php') ?>

</main>


<!-- Modal -->



<?php require('partials/footer.php') ?>
