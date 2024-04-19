<?php
    $title = "Home";
    require('partials/header.php')
?>


<main class="container">

<h1 class="text-center m-5">Details Book Page</h1>


<?php
    require('partials/search.php')
?>



<div class="row m-5">
      <div class="col-lg-6 border">
        <img src="<?= $book->getImage() ?>" class="img-fluid" alt="Product Image">
      </div>
      <div class="col-lg-6">
        <form action="./add_to_cart" method="post">
        <h2 class="mt-2 text-center"><?=  $book->getTitle();?></h2>
        <input type="hidden" name="book_id" value="<?=  $book->getId();?>">
        <ul class="list-group my-4">
          <li class="list-group-item">Category : <?= $book->getCategory()?->getName() ?></li>
          <li class="list-group-item">Author : <?= $book->getAuthor()?->getName()??"" ?></li>
        </ul>

        <h3 class="mb-3">Price : <?=  $book->getPrice();?> €</h3>
        <hr>
        <div class="d-flex align-items-center mb-3">
          <span class="me-2">Quantity:</span>
          <input type="number" class="form-control w-100" name="qty"  value="1" min="1">
        </div>
        <hr>
        <button class="btn btn-primary me-2 w-100" type="submit">Add to Cart</button>
        <hr>
        </form>
      </div>
    </div>

    <hr>
      <div class=" mt-5">
        <h4>Books of same Author</h4>
        <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 row-cols-xm-1 g-3">

        <?php foreach($books_same_author as $book): ?>

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

</div>
<hr>
        <div class="mt-5">
          <h4>Books of same category</h4>
          <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 row-cols-xm-1 g-3">
           
          
        <?php foreach($books_same_category as $book): ?>

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

        </div>    
         
            


      
</main>


<?php require('partials/footer.php') ?>
