<?php
    $title = "Admin Books Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">Admin Books Page</h1>

  <?php
      require('partials/search.php')
  ?>
  <a class="btn btn-primary" href="./add_book_form" >
    Add Book
  </a>

  <table class="table mt-5">
    <thead>
      <tr>
        <th scope="col">Isbn</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Book</th>
        <th scope="col">Category</th>
        <th scope="col">Price</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($books as $book): ?>
      <tr>
        <th scope="row"><?=$book->isbn ?></th>
        <td><img src="<?= $book->image ?>"    height= 100></td>
        <td><?= $book->title ?></td>
        <td><?= $book->category?->name??""  ?></td>
        <td><?= $book->author?->name??"" ?></td>
        <td><?= $book->price ?> €</td>
        <td>
          <a href="./book_details?id=<?= $book->id ?>" class="btn btn-primary">Show</a>
          <a href="./book_edit?id=<?= $book->id ?>" class="btn btn-warning">Edit</a>
          <button type="button" class="btn btn-danger delete-Book" data-bs-toggle="modal" data-bs-target="#deleteBook" data-id="<?= $book->id ?>">Delete</button>
        </td>

      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
  <!-- Add pagination -->
  <?php require('partials/pagination.php') ?>

</main>


<!-- Delete Book modal -->

<div class="modal fade" id="deleteBook" tabindex="-1" aria-labelledby="deleteBookLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="book_delete" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteBookLabel"> Delete Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Book?</p>
                    <input type="hidden" name="id" id="delete_Book_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Book</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    var deleteBookModal = document.getElementById('deleteBook')
    deleteBookModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var modalTitle = deleteBookModal.querySelector('.modal-title')
        var idInput = deleteBookModal.querySelector('#delete_Book_id')
        modalTitle.textContent = 'Delete Book'
        idInput.value = id
    })
</script>

<?php require('partials/footer.php') ?>

