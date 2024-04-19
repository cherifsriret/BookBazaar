<?php
    $title = "Home";
    require('partials/header.php')
?>

<main class="container">

<h1 class="text-center m-5">Checkout Page</h1>

<?php
    require('partials/search.php')
?>

<div class="row">
      <div class="col-lg-8">
        <form action="checkout" method="POST" accept-charset="utf-8">
        <hr>
        <h2>Shipping Address</h2>
       
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" class="form-control" id="first-name" name="first_name" placeholder="First Name" required>
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label for="last-name">Last Name</label>
                  <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" required>
                </div>
              </div>
          
              <div class="col-md-6">
                <!-- /.form-group -->
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                </div>  
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" id="state" name="state" placeholder="State" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="zip">Zip</label>
                          <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip" required>
                        </div>
                      </div>

                        
      </div>
     
      <hr>

      <div class="row">
        <div class="col"> <a href="./cart">< Return to Cart</a></div>
        <div class="col text-end"> <button class="btn btn-dark" type="submit">Validate Order</button> </div>
      </div>
      <hr>
    </form>
    </div>
      <!-- /.col-lg-8 -->
      <div class="col-lg-4">
          <div class="cart-totals bg-body-secondary px-4 py-5 rounded-3">
              <h3 class="my-3">Cart Items</h3>
              <?php $total_cart = 0; ?>
              <?php if($cart_count == 0): ?>
                      <p>No items in cart</p>
                    <?php else: ?>
                      <?php foreach($cart_books  as $cart_book): 
                         $total_cart += $cart_book->getBook()->getPrice() * $cart_book->getQty();
                         ?>
                        <div class="d-flex justify-content-between">
                          <img src="<?= $cart_book->getBook()->getImage() ?>" alt="" height= 50>
                          <span><?= $cart_book->getBook()->getTitle() ?></span>
                          <span><?= $cart_book->getQty() ?>*<?= $cart_book->getBook()->getPrice() ?>€</span>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
              
              <h3 class="my-3">Cart Totals</h3>
                  <table>
                      <tbody>
                          <tr>
                              <td>Subtotal</td>
                              <td class="subtotal"><?= $total_cart ?>€ </td>
                          </tr>
                          <tr>
                              <td>Shipping</td>
                              <td class="free-shipping">Free Shipping</td>
                          </tr>
                          <tr class="total-row">
                              <td>Total</td>
                              <td class="price-total"><?= $total_cart ?>€</td>
                          </tr>
                      </tbody>
                  </table>
                  <!-- /.btn-cart-totals -->
          </div>
          <!-- /.cart-totals -->
      </div>
      <!-- /.col-lg-4 -->
  </div>

</main>


<?php require('partials/footer.php') ?>
