<?php
    $title = "Home";
    require('partials/header.php')
?>

<main class="container">

<h1 class="text-center m-5">All Books Page</h1>

<?php
    require('partials/search.php')
?>



<!-- filer form -->
<form class="row g-3 my-3" method="GET" action="all_books">
<div class="col-md-3">
<label for="author" class="form-label">Author</label>
<select class="form-select" id="author" name="author">
<option selected  value="">Choose...</option>
<?php foreach($all_authors as $author): ?>
<option value="<?= $author->getId() ?>" <?= $selected_author==$author->getId() ? 'selected' : '' ?>><?= $author->getName() ?></option>
<?php endforeach; ?>

</select>
</div>
<div class="col-md-3">
<div class="form-group">
<label for="category" class="form-label">Category</label>
<select class="form-select" id="category" name="category">
    
  <option selected value="">Choose...</option>

  <?php foreach($all_categories as $category): ?>
  <option value="<?= $category->getId() ?>" <?= $selected_category==$category->getId() ? 'selected' : '' ?>><?= $category->getName() ?></option>
  <?php endforeach; ?>
  
</select>

    
</div>


</div>
<!-- <div class="col-md-3">
<label for="year" class="form-label">Year</label>
<select class="form-select" id="year">
<option selected>Choose...</option>
<option value="year1">Year 1</option>
<option value="year2">Year 2</option>
<option value="year3">Year 3</option>
</select>
</div> -->
<div class="col-md-3">
<button type="submit" class="btn btn-dark mt-2 p-3">Filter</button>
</div>
</form>

<!-- end filer form -->


<div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 row-cols-xm-1 g-3 my-5">

<?php foreach($books as $book): ?>
<div class="col">
  <div class="card">
    <img src="<?= $book->getImage() ?>" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title"><?= $book->getTitle() ?></h5>
      <p class="card-text"><?= $book->getPrice() ?> €</p>
    </div>
      <div class="card-footer text-center"> <a class="btn btn-dark" href="./book_details?id=<?= $book->getId() ?>">Add To Cart</a></div>
  </div>
</div>
<?php endforeach; ?>
</div>


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
  <a class="page-link" href="./all_books?page=1&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">First</a>
</li>
<li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./all_books?page=<?php echo $currentPage - 1; ?>&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">Previous</a>
</li>

<?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
  <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
    <a class="page-link" href="./all_books?page=<?php echo $i; ?>&<?= $currentParamsString ?>"><?php echo $i; ?></a>
  </li>
<?php endfor; ?>

<li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./all_books?page=<?php echo $currentPage + 1; ?>&<?= $currentParamsString ?>">Next</a>
</li>
<li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./all_books?page=<?php echo $totalPages; ?>&<?= $currentParamsString ?>">Last</a>
</li>


</main>


<?php require('partials/footer.php') ?>
