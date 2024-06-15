<?php
    $title = "Details Book Page";
    require('partials/header.php')
?>

<main class="container">
  <h1 class="text-center m-5">Details Book Page</h1>
  <?php
      require('partials/search.php')
  ?>
  <div class="row m-5">
    <div class="col-lg-6 border text-center p-2">
      <img src="<?= htmlentities($book->image) ?>" class="img-fluid" alt="Product Image">
    </div>
    <div class="col-lg-6">
      <form action="./add_to_cart" method="post">
        <h2 class="mt-2 text-center"><?= htmlentities($book->title) ?></h2>
        <input type="hidden" name="book_id" value="<?= urlencode($book->id) ?>">
        <ul class="list-group my-4">
          <li class="list-group-item">Category : <?= htmlentities($book->category->name)??"" ?></li>
          <li class="list-group-item">Author : <?= htmlentities($book->author->name)??"" ?></li>
        </ul>
        <h3 class="mb-3">Price : <?= htmlentities($book->price) ?> €</h3>
        <hr>
        <div class="d-flex align-items-center mb-3">
          <span class="me-2">Quantity:</span>
          <input type="number" class="form-control w-100" name="qty"  value="1" min="1">
        </div>
        <hr>
        <button class="btn btn-primary me-2 w-100" type="submit">Add to Cart</button>
        <hr>
      </form>
      <?php if($currentUser): ?>
        <!-- add or delete from wishlist -->
        <?php if($is_in_wishlist): ?>
          <form action="./remove_from_wishlist" method="post">
            <input type="hidden" name="book_id" value="<?= urlencode($book->id) ?>">
            <button class="btn btn-danger w-100" type="submit">Remove from Wishlist</button>
          </form>
        <?php else: ?>
          <form action="./add_to_wishlist" method="post">
            <input type="hidden" name="book_id" value="<?= urlencode($book->id) ?>">
            <button class="btn btn-success w-100" type="submit">Add to Wishlist</button>
          </form>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>

  <hr>
  <div class=" mt-5">
    <h4>Books of same Author</h4>
    <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 row-cols-xm-1 g-3">
      <?php foreach($books_same_author as $book): ?>
        <div class="col">
          <div class="card">
              <a  href="./book_details?id=<?= urlencode($book->id) ?>">
                  <img src="<?= htmlentities($book->image) ?>" class="card-img-top" alt="...">
              </a>
              <div class="card-body">
                <h5 class="card-title"><?= htmlentities($book->title) ?></h5>
                <p class="card-text"><?= htmlentities($book->price) ?> €</p>
              </div>
              <div class="card-footer text-center"> 
                <a class="btn btn-dark" href="./book_details?id=<?= urlencode($book->id) ?>">Show Details</a>
              </div>
            </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <hr>
  <div class="mt-5">
    <h4>Books of same category</h4>
    <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 row-cols-xm-1 g-3">
      <?php foreach($books_same_category as $book): ?>
        <div class="col">
          <div class="card">
              <a  href="./book_details?id=<?= urlencode($book->id) ?>">
                  <img src="<?= htmlentities($book->image) ?>" class="card-img-top" alt="...">
              </a>
              <div class="card-body">
                <h5 class="card-title"><?= htmlentities($book->title) ?></h5>
                <p class="card-text"><?= htmlentities($book->price) ?> €</p>
              </div>
              <div class="card-footer text-center"> 
                <a class="btn btn-dark" href="./book_details?id=<?= urlencode($book->id) ?>">Show Details</a>
              </div>
            </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>    
</main>

<?php require('partials/footer.php') ?>
