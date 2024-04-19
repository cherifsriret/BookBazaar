<?php
    $title = "Home";
    require('partials/header.php')
?>

<main class="container">

<h1 class="text-center m-5">Wishlist Page</h1>

<?php
    require('partials/search.php')
?>

<table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">Isbn</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Author</th>
      <th scope="col">Category</th>
      <th scope="col">Price</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($books as $book): ?>
    <tr>
      <th scope="row"><?=$book->getIsbn() ?></th>
      <td><img src="<?= $book->getImage() ?>"    height= 100></td>
      <td><?= $book->getTitle() ?></td>
      <td><?= $book->getCategory()?->getName() ?></td>
      <td><?= $book->getAuthor()?->getName()??"" ?></td>
      <td><?= $book->getPrice() ?> €</td>
      <td>
        <a href="./book_details?id=<?= $book->getId() ?>" class="btn btn-primary">Show</a>
        <button class="btn btn-danger delete-wishlist" data-id="<?= $book->getId() ?>">Remove from whishlist</button>
      </td>

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>




</main>


<?php require('partials/footer.php') ?>
