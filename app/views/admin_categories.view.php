<?php
    $title = "Admin Categories Page";
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
          <th scope="row"><?= urlencode($category->id) ?></th>
          <td><?= htmlentities($category->name) ?></td>
          <td>
            <button type="button" class="btn btn-warning update-category" data-bs-toggle="modal" data-bs-target="#updateCategory" data-id="<?= urlencode($category->id) ?>" data-name="<?= htmlentities($category->name) ?>">Edit</button>
            <button type="button" class="btn btn-danger delete-category" data-bs-toggle="modal" data-bs-target="#deleteCategory" data-id="<?= urlencode($category->id) ?>">Delete</button>
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
  let updateCategoryModal = document.getElementById('updateCategory')
  updateCategoryModal.addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget
    let id = button.getAttribute('data-id')
    let name = button.getAttribute('data-name')
    let modalTitle = updateCategoryModal.querySelector('.modal-title')
    let nameInput = updateCategoryModal.querySelector('#name')
    let idInput = updateCategoryModal.querySelector('#update_category_id')
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
  let deleteCategoryModal = document.getElementById('deleteCategory')
  deleteCategoryModal.addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget
    let id = button.getAttribute('data-id')
    let modalTitle = deleteCategoryModal.querySelector('.modal-title')
    let idInput = deleteCategoryModal.querySelector('#delete_category_id')
    modalTitle.textContent = 'Delete Category'
    idInput.value = id
  })
</script>

