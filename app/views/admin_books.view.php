<?php
    $title = "Home";
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
        <a href="./book_edit?id=<?= $book->getId() ?>" class="btn btn-warning">Edit</a>
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
  <a class="page-link" href="./admin_books?page=1&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">First</a>
</li>
<li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./admin_books?page=<?php echo $currentPage - 1; ?>&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">Previous</a>
</li>

<?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
  <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
    <a class="page-link" href="./admin_books?page=<?php echo $i; ?>&<?= $currentParamsString ?>"><?php echo $i; ?></a>
  </li>
<?php endfor; ?>

<li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./admin_books?page=<?php echo $currentPage + 1; ?>&<?= $currentParamsString ?>">Next</a>
</li>
<li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
  <a class="page-link" href="./admin_books?page=<?php echo $totalPages; ?>&<?= $currentParamsString ?>">Last</a>
</li>


</main>


<?php require('partials/footer.php') ?>
