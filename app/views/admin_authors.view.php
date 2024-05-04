<?php
    $title = "Admin Authors Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">Admin Authors Page</h1>

  <?php
      require('partials/search.php')
  ?>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAuthor">
    Add Author
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
    <?php foreach($authors as $author): ?>
      <tr>
        <th scope="row"><?=$author->getId() ?></th>
        <td><?= $author->getName() ?></td>
        <td>
          <button type="button" class="btn btn-warning update-author" data-bs-toggle="modal" data-bs-target="#updateAuthor" data-id="<?= $author->getId() ?>" data-name="<?= $author->getName() ?>">Edit</button>
          <button type="button" class="btn btn-danger delete-author" data-bs-toggle="modal" data-bs-target="#deleteAuthor" data-id="<?= $author->getId() ?>">Delete</button>
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
        <a class="page-link" href="./admin_authors?page=1&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">First</a>
      </li>
      <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./admin_authors?page=<?php echo $currentPage - 1; ?>&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">Previous</a>
      </li>

      <?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
        <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
          <a class="page-link" href="./admin_authors?page=<?php echo $i; ?>&<?= $currentParamsString ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./admin_authors?page=<?php echo $currentPage + 1; ?>&<?= $currentParamsString ?>">Next</a>
      </li>
      <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./admin_authors?page=<?php echo $totalPages; ?>&<?= $currentParamsString ?>">Last</a>
      </li>
    </ul>
  </nav>
</main>

<!-- Modal -->

<?php require('partials/footer.php') ?>

<!-- Modal add author -->
<div class="modal fade" id="addAuthor" tabindex="-1" aria-labelledby="addAuthorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="add_author" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addAuthorLabel"> Add Author</h1>
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
        <button type="submit" class="btn btn-primary">Add Author</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal update author -->

<div class="modal fade" id="updateAuthor" tabindex="-1" aria-labelledby="updateAuthorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="update_author" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateAuthorLabel"> Update Author</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <input type="hidden" name="id" id="update_author_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Author</button>
      </div>
      </form>
    </div>
  </div>

</div>

<script>
  var updateAuthorModal = document.getElementById('updateAuthor')
  updateAuthorModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    var id = button.getAttribute('data-id')
    var name = button.getAttribute('data-name')
    var modalTitle = updateAuthorModal.querySelector('.modal-title')
    var nameInput = updateAuthorModal.querySelector('#name')
    var idInput = updateAuthorModal.querySelector('#update_author_id')
    modalTitle.textContent = 'Update Author'
    nameInput.value = name
    idInput.value = id
  })
</script>


<!-- Delete author modal -->
<div class="modal fade" id="deleteAuthor" tabindex="-1" aria-labelledby="deleteAuthorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="delete_author" method="POST">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteAuthorLabel"> Delete Author</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <p>Are you sure you want to delete this author?</p>
            <input type="hidden" name="id" id="delete_author_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Delete Author</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  var deleteAuthorModal = document.getElementById('deleteAuthor')
  deleteAuthorModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    var id = button.getAttribute('data-id')
    var modalTitle = deleteAuthorModal.querySelector('.modal-title')
    var idInput = deleteAuthorModal.querySelector('#delete_author_id')
    modalTitle.textContent = 'Delete Author'
    idInput.value = id
  })
</script>

