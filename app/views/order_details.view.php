<?php
    $title = "Order Details Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">Order Details Page</h1>

  <?php
    require('partials/search.php')
  ?>

  <div class="row my-6">
    <div class="col-lg-6">
      <hr>
      <h2>Shipping Address</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" class="form-control" id="first-name" name="first_name" placeholder="First Name" value="<?= htmlentities($order->first_name) ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" value="<?= htmlentities($order->last_name) ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <!-- /.form-group -->
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= htmlentities($order->email) ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?= htmlentities($order->phone) ?>" disabled>
          </div>  
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?= htmlentities($order->address) ?>" disabled>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?= htmlentities($order->city) ?>" disabled>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="state">State</label>
            <input type="text" class="form-control" id="state" name="state" placeholder="State" value="<?= htmlentities($order->status) ?>" disabled>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="zip">Zip</label>
            <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip" value="<?= htmlentities($order->zip_code) ?>" disabled>
          </div>
        </div>
      </div>
      <hr>
    </div>
    <!-- /.col-lg-6 -->
    <div class="col-lg-6">
      <br>
      <div class="cart-totals bg-body-secondary px-4 py-2 rounded-3">
        <h3 class="my-3">Order Status : <span class="label label-info"> <?= htmlentities($order->status) ?></span> </h3>
        <?php $total_order = 0; ?>
        <?php foreach($order_items  as $order_item): 
            $total_order +=htmlentities($order_item->price) * htmlentities($order_item->qty) ;
            ?>
          <div class="d-flex justify-content-between mt-3">
            <img src="<?= htmlentities($order_item->book->image) ?>" alt="" height= 50>
            <span><?= htmlentities($order_item->book->title) ?></span>
            <span><?= htmlentities($order_item->qty) ?>*<?= htmlentities($order_item->price) ?>€</span>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="cart-totals bg-body-secondary px-4 py-2 rounded-3 mt-2">
        <h3 class="my-3">Order Totals</h3>
          <table>
            <tbody>
              <tr>
                <td>Subtotal</td>
                <td class="subtotal"><?= htmlentities($total_order) ?>€ </td>
              </tr>
              <tr>
                <td>Shipping</td>
                <td class="free-shipping">Free Shipping</td>
              </tr>
              <tr class="total-row">
                <td>Total</td>
                <td class="price-total"><?= htmlentities($total_order) ?>€</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
    <!-- /.col-lg-4 -->
  </div>

</main>

<?php require('partials/footer.php') ?>
