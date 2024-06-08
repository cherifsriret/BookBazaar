<?php
    $title = "All Books Page";
    require('partials/header.php')
?>

<main class="container">
  <h1 class="text-center m-5">All Books Page</h1>
  <?php require('partials/search.php') ?>
  <!-- filer form -->
  <form class="row g-3 mt-3">
    <div class="col-auto">
      <label for="category" class="col-form-label">Category</label>
    </div>
    <div class="col">
      <select class="form-select" id="category" name="category">
        <option selected value="">Choose...</option>
        <?php foreach($all_categories as $category): ?>
          <option value="<?= urlencode($category->id) ?>" <?= $selected_category == urlencode($category->id)  ? 'selected' : '' ?>><?=  htmlentities($category->name) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <label for="author" class="col-form-label">Author</label>
    </div>
    <div class="col">
      <select class="form-select" id="author" name="author">
        <option selected  value="">Choose...</option>
        <?php foreach($all_authors as $author): ?>
          <option value="<?= urlencode($author->id) ?>" <?= $selected_author== urlencode($author->id) ? 'selected' : '' ?>><?= htmlentities($author->name) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col">
      <button type="submit" class="btn btn-dark mb-3">Filter</button>
    </div>
  </form>
  <!-- end filter form -->
  <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 row-cols-xm-1 g-3 my-5">
    <?php foreach($books as $book): ?>
      <div class="col">
        <div class="card">
            <img src="<?= htmlentities($book->image) ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?= htmlentities($book->title) ?></h5>
              <p class="card-text"><?= htmlentities($book->price) ?> €</p>
            </div>
            <div class="card-footer text-center"> 
              <a class="btn btn-dark" href="./book_details?id=<?= urlencode($book->id) ?>">Add To Cart</a>
            </div>
          </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Add pagination -->
  <?php require('partials/pagination.php') ?>

</main>


<?php require('partials/footer.php') ?>
