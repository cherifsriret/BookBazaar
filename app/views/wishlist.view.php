<?php
    $title = "Wishlist Page";
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
          <th scope="row"><?=  htmlentities($book->isbn) ?></th>
          <td><img src="<?=  htmlentities($book->image) ?>"    height= 100></td>
          <td><?=  htmlentities($book->title) ?></td>
          <td><?=  htmlentities($book->category?->name??"") ?></td>
          <td><?=  htmlentities($book->author?->name??"") ?></td>
          <td><?=  htmlentities($book->price) ?> €</td>
          <td>
            <a href="./book_details?id=<?= urlencode($book->id) ?>" class="btn btn-primary">Show</a>
            <button class="btn btn-danger delete-wishlist" data-id="<?= urlencode($book->id) ?>">Remove from whishlist</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>


<?php require('partials/footer.php') ?>
