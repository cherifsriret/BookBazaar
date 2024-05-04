<ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
    <li><a href="./" class="nav-link px-2 link-secondary">Home</a></li>
    <li><a href="./all_books" class="nav-link px-2">All Books</a></li>
    <?php if($currentUser): ?>
        <li><a href="./my_orders" class="nav-link px-2">My Orders</a></li>
        <li><a href="./wishlist" class="nav-link px-2">Withlist</a></li>
        <li><a href="./checkout_form" class="nav-link px-2">Checkout</a></li>
        <li><a href="./profile" class="nav-link px-2">Profile</a></li>
        <?php if($currentUser['role'] == 'moderator' || $currentUser['role'] == 'administrator'): ?>
            <li>
                <div class="dropdown">
                    <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        Administration
                    </button>
                    <div class="dropdown-menu p-4 login-dropdown-form">
                        <a class="dropdown-item" href="./admin_books">Books Management</a>
                        <a class="dropdown-item" href="./admin_orders">Orders Managment</a>
                        <a class="dropdown-item" href="./admin_authors">Authors Managment</a>
                        <a class="dropdown-item" href="./admin_categories">Categories Managment</a>
                        <a class="dropdown-item" href="./admin_users">Users Managment</a>
                        <?php if($currentUser['role'] == 'administrator'): ?>
                            <a class="dropdown-item" href="./admin_moderators">Moderator Managment</a>
                        <?php endif; ?>
                    </div>
            </li>
        <?php endif; ?>
        <li> 
            <form class="logout-form" action="logout" method="post">
                <div class="form-group">
                    <button class="nav-link px-2" type="submit">Logout</button>
                </div>
            </form>
        </li>
    <?php else: ?>
        <li>
            <div class="dropdown">
                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                Login
                </button>
                <form class="dropdown-menu p-4 login-dropdown-form" method="POST" action="login">
                <div class="mb-3">
                    <label for="exampleDropdownFormEmail2" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                </div>
                <div class="mb-3">
                    <label for="exampleDropdownFormPassword2" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleDropdownFormPassword2" placeholder="Password">
                </div>
                <div class="mb-3">
                    <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                    <label class="form-check-label" for="dropdownCheck2">
                        Remember me
                    </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark">Sign in</button>
                </form>
            </div>
        </li>
        <li><a href="./register_form" class="nav-link px-2">Register</a></li>
    <?php endif; ?>
    <?php if($currentUser && $currentUser['role'] == 'admin'): ?>
        <li><a href="./admin" class="nav-link px-2">Admin</a></li>
    <?php endif; ?>
</ul>