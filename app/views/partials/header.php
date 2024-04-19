<?php
require_once "app/models/BookCart.php";
require_once "app/models/Book.php";
 $currentUser = Helper::getSession('user');
 $cart_books  = [];
 if($currentUser){

     $cart_books  = BookCart::fetchUserCart($currentUser['id']);
     foreach ($cart_books  as $cart_book) {
         $book_c = Book::fetchId($cart_book->getBookId());
         $cart_book->setBook($book_c);
     }
     $cart_count = count($cart_books );
 }
  else{
     $cart_count = 0;
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>

    
    <div class="bg-dark">

    <header class="container d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <div class="col-md-2 mb-2 mb-md-0" bis_skin_checked="1">
          <a href="./" class="d-inline-flex link-body-emphasis text-decoration-none">
            <img src="./public/logo.png" alt="Logo" class="logo">
          </a>
        </div>
  
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
                </form>
              </div>
          </li>

<?php endif; ?>
            <li> <form class="logout-form" action="logout" method="post">
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
  
        <div class="col-md-3 text-end" bis_skin_checked="1">
            <div class="dropdown">
                <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  Cart
                </button>
                <div class="dropdown-menu p-4">
                    <h5>Items added  To Cart</h5>
                    <hr class="dropdown-divider">
                  <div class="mb-3">
                    <?php if($cart_count == 0): ?>
                      <p>No items in cart</p>
                    <?php else: ?>
                      <?php foreach($cart_books  as $cart_book): ?>
                        <div class="d-flex justify-content-between">
                          <img src="<?= $cart_book->getBook()->getImage() ?>" alt="" height= 50>
                          <span><?= $cart_book->getBook()->getTitle() ?></span>
                          <span><?= $cart_book->getQty() ?>x<?= $cart_book->getBook()->getPrice() ?>€</span>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                    
                  </div>
                  <div class="mb-3">
                   
                  </div>
                <hr class="dropdown-divider">
                <div class="row">
                  <a href="./cart" class="btn btn-secondary col m-2">View My Cart</a>
                  <a href="./checkout_form" class="btn btn-dark col m-2">Checkout</a>
                </div>
                 
                </div>
              </div>
        </div>
      </header>
    </div>
    
   <?php
      if (isset($_SESSION['message'])) {
         echo "<span>", htmlentities($_SESSION['message']), "</span>";
         unset($_SESSION['message']);
      }
      if (isset($_SESSION['error'])) {
         echo '<span style="background-color: red;">', htmlentities($_SESSION['error']), "</span>";
         unset($_SESSION['error']);
      }
    ?>
