<?php
    $title = "Home";
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
      <th scope="row"><?=$user->getId() ?></th>
      <td><?= $user->getFirstName() ?></td>
      <td><?= $user->getLastName() ?></td>
      <td><?= $user->getEmail() ?></td>
      <td><?= $user->getPhone() ?></td>
      <td><?= $user->getRole() ?></td>
      <td></td>
      <td>
        <a href="./user_edit?id=<?= $user->getId() ?>" class="btn btn-primary">Edit</a>
        <a href="./user_delete?id=<?= $user->getId() ?>" class="btn btn-danger">Delete</a>
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


</main>


<!-- Modal -->



<?php require('partials/footer.php') ?>
