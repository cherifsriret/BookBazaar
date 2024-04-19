
<div class="bg-dark">

<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-5 border-top container">
  <p class="col-md-4 mb-0 text-light">© 2024 Company, Inc</p>

  <a href="./" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
   
    <img src="./public/logo.png" alt="Logo" class="logo">
  </a>

  <ul class="nav col-md-4 justify-content-end">
    <li class="nav-item"><a href="./" class="nav-link px-2 text-light">Home</a></li>
    <li class="nav-item"><a href="./all_books" class="nav-link px-2 text-light">All Books</a></li>
   

    <?php if($currentUser): ?>
          <li class="nav-item"><a href="./checkout_form" class="nav-link px-2 text-light">Checkout</a></li>
          <li class="nav-item"><a href="./my_orders" class="nav-link px-2 text-light">My Orders</a></li>

            <?php else: ?>
              <li class="nav-item"><a href="./login_form" class="nav-link px-2 text-light">Login</a></li>
          <li class="nav-item"><a href="./register_form" class="nav-link px-2 text-light">Register</a></li>
              <?php endif; ?>
  </ul>

  <script src="./public/script.js"></script>

</footer>

</div>

</body>
</html>