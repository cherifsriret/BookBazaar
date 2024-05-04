<?php
    $title = "Login Page";
    require('partials/header.php')
?>

<main class="container">

    <h1 class="text-center m-5">Login Page</h1>

    <?php
        require('partials/search.php')
    ?>
    <form class="mt-5" action="login" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary my-2">Login</button>
        <br>
        You don't have an account?
        <a href="./register_form">Register</a>
    </form>

</main>


<?php require('partials/footer.php') ?>
