<?php
$title = "Edit Book Page";
require('partials/header.php')
?>

<main class="container">

    <h1 class="text-center m-5">Edit Book Page</h1>

    <?php
    require('partials/search.php')
    ?>
    <form class="mt-5" action="./book_edit_post" method="POST">
        <input type="hidden" name="id" value="<?=  urlencode($book->id)?>">
        <div class="form-group">
            <label for="Isbn">Isbn</label>
            <input type="text" class="form-control" id="Isbn" name="Isbn" value="<?=  htmlentities($book->isbn)?>" required>
        </div>
        <div class="form-group">
            <label for="Title">Title</label>
            <input type="text" class="form-control" id="Title" name="Title"  value="<?=  htmlentities($book->title)?>" required>
        </div>
        <div class="form-group">
            <label for="Image">Image</label>
            <input type="text" class="form-control" id="Image" name="Image"  value="<?=  htmlentities($book->image)?>" required>
        </div>
        <div class="form-group">
            <label for="Price">Price (€)</label>
            <input type="number" class="form-control" id="Price" name="Price"  value="<?=  htmlentities($book->price)?>" required>
        </div>

        <div class="form-group">
            <label for="Author">Author</label>
            <select class="form-control" id="Author" name="Author" required>
                <?php foreach($authors as $author): ?>
                    <option value="<?= urlencode($author->id) ?>" <?= urlencode($book->author_id) == urlencode($author->id) ? 'selected' : '' ?>><?= htmlentities($author->name) ?> </option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="form-group">
            <label for="Category">Category</label>
            <select class="form-control" id="Category" name="Category" required>
                <?php foreach($categories as $category): ?>
                    <option value="<?= urlencode($category->id) ?>" <?= urlencode($book->category_id) == urlencode($category->id) ? 'selected' : '' ?>><?= htmlentities($category->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="IsFeatured">Is Featured</label>
            <input type="checkbox" class="form-check" id="IsFeatured" name="IsFeatured" <?= htmlentities($book->is_featured) ? 'checked' : '' ?>>
        </div>

        <button type="submit" class="btn btn-primary my-2">Add Book</button>
    </form>

</main>


<?php require('partials/footer.php') ?>
