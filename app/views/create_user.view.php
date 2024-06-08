<?php
    $title = "Create User Page";
    require('partials/header.php')
?>

<main class="container">

    <h1 class="text-center m-5">Create User Page</h1>

    <?php
        require('partials/search.php')
    ?>
    <form class="mt-5" action="./create_user_post" method="POST">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="moderator" >Moderator</option>
                <?php if($currentUser['role'] == 'administrator'): ?>
                    <option value="administrator">Administrator</option>
                <?php endif; ?>
                <option value="user">User</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        
        <button type="submit" class="btn btn-primary my-2">Create User</button>
    </form>

</main>


<?php require('partials/footer.php') ?>
