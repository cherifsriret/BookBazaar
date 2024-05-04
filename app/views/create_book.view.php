<?php
    $title = "Create Book Page";
    require('partials/header.php')
?>

<main class="container">

    <h1 class="text-center m-5">Create Book Page</h1>

    <?php
        require('partials/search.php')
    ?>
    <form class="mt-5" action="./book_add" method="POST">
    
        <div class="form-group">
            <label for="Isbn">Isbn</label>
            <input type="text" class="form-control" id="Isbn" name="Isbn" value="" required>
        </div>
        <div class="form-group">
            <label for="Title">Title</label>
            <input type="text" class="form-control" id="Title" name="Title" value="" required>
        </div>
        <div class="form-group">
            <label for="Image">Image</label>
            <input type="text" class="form-control" id="Image" name="Image" value="" required>
        </div>
        <div class="form-group">
            <label for="Price">Price (€)</label>
            <input type="number" class="form-control" id="Price" name="Price" value="" required>
        </div>

        <div class="form-group">
            <label for="Author">Author</label>
            <select class="form-control" id="Author" name="Author" required>
                <?php foreach($authors as $author): ?>
                    <option value="<?= $author->getId() ?>" ><?= $author->getName() ?> </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Category">Category</label>
            <select class="form-control" id="Category" name="Category" required>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->getId() ?>" ><?= $category->getName() ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="IsFeatured">Is Featured</label>
            <input type="checkbox" class="form-check" id="IsFeatured" name="IsFeatured" >
        </div>

        <button type="submit" class="btn btn-primary my-2">Add Book</button>
    </form>

</main>

<?php require('partials/footer.php') ?>
