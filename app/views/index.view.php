<?php
    $title = "Home Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">Home Page</h1>

  <?php
      require('partials/search.php')
  ?>

  <div class="mt-5">
    <h2>Latest books</h2>
    <div class="row row-cols-1 row-cols-md-4 g-3">
      <?php foreach($latestBooks as $book): ?>
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

  <div class="mt-5">
    <h2>Best Selling books</h2>
    <div class="row row-cols-1 row-cols-md-4 g-3">
      <?php foreach($bestSellerBooks as $book): ?>
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

  <div class="mt-5">
    <h2>Featured books</h2>
    <div class="row row-cols-1 row-cols-md-4 g-3">
      <?php foreach($featuredBooks as $book): ?>
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
