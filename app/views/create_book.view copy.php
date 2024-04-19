<?php
    $title = "Home";
    require('partials/header.php')
?>

<main class="container">

<h1 class="text-center m-5">Update Profile Page</h1>

<?php
    require('partials/search.php')
?>
<form class="mt-5" action="./book_add" method="POST">
  
    <div class="form-group">
        <label for="IsFeatured">Is Featured</label>
        <input type="checkbox" class="form-control" id="IsFeatured" name="IsFeatured" <?= $book->getIsFeatured() ? 'checked' : '' ?>>
    </div>
    
    <button type="submit" class="btn btn-primary my-2">Update Book</button>
</form>

</main>


<?php require('partials/footer.php') ?>
