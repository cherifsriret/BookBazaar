<?php
    $title = "Home";
    require('partials/header.php')
?>

<main class="container">

<h1 class="text-center m-5">Register Page</h1>

<?php
    require('partials/search.php')
?>
<form class="mt-5" action="register" method="POST">
  
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" required>
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" class="form-control" id="phone" name="phone" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password Confirmation</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>
    
    <button type="submit" class="btn btn-primary my-2">Register</button>
    <br>
    You have an account?
    <a href="login_form">Login</a>
</form>

</main>


<?php require('partials/footer.php') ?>
