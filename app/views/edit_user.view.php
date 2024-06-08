<?php
    $title = "Update User Page";
    require('partials/header.php')
?>

<main class="container">

    <h1 class="text-center m-5">Update User Page</h1>

    <?php
        require('partials/search.php')
    ?>
    <form class="mt-5" action="./edit_user_post" method="POST">
        <input type="hidden" name="id" value="<?= $user->id ?>">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" value="<?= htmlentities($user->first_name) ?>" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" value="<?= htmlentities($user->last_name) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= htmlentities($user->email) ?>" disabled>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlentities($user->phone) ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="moderator" <?= $user->role == 'moderator' ? 'selected' : '' ?>>Moderator</option>
                <?php if($currentUser['role'] == 'administrator'): ?>
                    <option value="administrator" <?= $user->role == 'administrator' ? 'selected' : '' ?>>Administrator</option>
                <?php endif; ?>
                <option value="user" <?= $user->role == 'user' ? 'selected' : '' ?>>User</option>
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
        
        <button type="submit" class="btn btn-primary my-2">Update User</button>
    </form>

</main>


<?php require('partials/footer.php') ?>
