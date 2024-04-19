<?php
    $title = "Home";
    require('partials/header.php')
?>

<main class="container">

<h1 class="text-center m-5">Admin Categories Page</h1>

<?php
    require('partials/search.php')
?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
  Add Category
</button>


<table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($categories as $category): ?>
    <tr>
      <th scope="row"><?=$category->getId() ?></th>
      <td><?= $category->getName() ?></td>
      <td>
        <button type="button" class="btn btn-warning update-category" data-bs-toggle="modal" data-bs-target="#updateCategory" data-id="<?= $category->getId() ?>" data-name="<?= $category->getName() ?>">Edit</button>
        <button type="button" class="btn btn-danger delete-category" data-bs-toggle="modal" data-bs-target="#deleteCategory" data-id="<?= $category->getId() ?>">Delete</button>
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
  <a class="page-link" href="./admin_categories?page=1&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">First</a>
</li>
<li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./admin_categories?page=<?php echo $currentPage - 1; ?>&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">Previous</a>
</li>

<?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
  <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
    <a class="page-link" href="./admin_categories?page=<?php echo $i; ?>&<?= $currentParamsString ?>"><?php echo $i; ?></a>
  </li>
<?php endfor; ?>

<li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./admin_categories?page=<?php echo $currentPage + 1; ?>&<?= $currentParamsString ?>">Next</a>
</li>
<li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./admin_categories?page=<?php echo $totalPages; ?>&<?= $currentParamsString ?>">Last</a>
</li>


</main>


<!-- Modal -->



<?php require('partials/footer.php') ?>

<!-- Modal add category -->
<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="add_category" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addCategoryLabel"> Add Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
       
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>

            </div>
      

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Category</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal update category -->

<div class="modal fade" id="updateCategory" tabindex="-1" aria-labelledby="updateCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="update_category" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateCategoryLabel"> Update Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <input type="hidden" name="id" id="update_category_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Category</button>
      </div>
      </form>
    </div>
  </div>

</div>

<script>
  var updateCategoryModal = document.getElementById('updateCategory')
  updateCategoryModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    var id = button.getAttribute('data-id')
    var name = button.getAttribute('data-name')
    var modalTitle = updateCategoryModal.querySelector('.modal-title')
    var nameInput = updateCategoryModal.querySelector('#name')
    var idInput = updateCategoryModal.querySelector('#update_category_id')
    modalTitle.textContent = 'Update Category'
    nameInput.value = name
    idInput.value = id
  })
</script>


<!-- Delete category modal -->

<div class="modal fade" id="deleteCategory" tabindex="-1" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="delete_category" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteCategoryLabel"> Delete Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <p>Are you sure you want to delete this category?</p>
            <input type="hidden" name="id" id="delete_category_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete Category</button>
      </div>
      </form>
    </div>
  </div>

</div>

<script>
  var deleteCategoryModal = document.getElementById('deleteCategory')
  deleteCategoryModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    var id = button.getAttribute('data-id')
    var modalTitle = deleteCategoryModal.querySelector('.modal-title')
    var idInput = deleteCategoryModal.querySelector('#delete_category_id')
    modalTitle.textContent = 'Delete Category'
    idInput.value = id
  })
</script>

