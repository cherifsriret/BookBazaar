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
      <h2>User Info</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" class="form-control" id="first-name" name="first_name" placeholder="First Name" value="<?= $order->getUser()->getFirstName() ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" value="<?= $order->getUser()->getLastName() ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <!-- /.form-group -->
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $order->getUser()->getEmail() ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?= $order->getUser()->getPhone() ?>" disabled>
          </div>  
        </div>
      </div>
      <hr>
      <h2>Shipping Address</h2>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" class="form-control" id="first-name" name="first_name" placeholder="First Name" value="<?= $order->getFirstName() ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" class="form-control" id="last-name" name="last_name" placeholder="Last Name" value="<?= $order->getLastName() ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <!-- /.form-group -->
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $order->getEmail() ?>" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?= $order->getPhone() ?>" disabled>
          </div>  
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?= $order->getAddress() ?>" disabled>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?= $order->getCity() ?>" disabled>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="state">State</label>
            <input type="text" class="form-control" id="state" name="state" placeholder="State" value="<?= $order->getState() ?>" disabled>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="zip">Zip</label>
            <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip" value="<?= $order->getZipCode() ?>" disabled>
          </div>
        </div>
      </div>
      <hr>
    </div>
    <!-- /.col-lg-6 -->
    <div class="col-lg-6">
      <br>
      <div class="cart-totals bg-body-secondary px-4 py-2 rounded-3">
        <h3 class="my-3">Order Status : <span class="label label-info"> <?= $order->getStatus() ?></span> </h3>
          <?php $total_order = 0; ?>
          <?php foreach($order_items  as $order_item): 
            $total_order += $order_item->getPrice() * $order_item->getQty();
            ?>
            <div class="d-flex justify-content-between mt-3">
              <img src="<?= $order_item->getBook()->getImage() ?>" alt="" height= 50>
              <span><?= $order_item->getBook()->getTitle() ?></span>
              <span><?= $order_item->getQty() ?>*<?= $order_item->getPrice() ?>€</span>
            </div>
          <?php endforeach; ?>
      </div>
      <div class="cart-totals bg-body-secondary px-4 py-2 mt-2 rounded-3">
        <h3 class="my-3">Order Totals</h3>
        <table>
            <tbody>
                <tr>
                    <td>Subtotal</td>
                    <td class="subtotal"><?= $total_order ?>€ </td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td class="free-shipping">Free Shipping</td>
                </tr>
                <tr class="total-row">
                    <td>Total</td>
                    <td class="price-total"><?= $total_order ?>€</td>
                </tr>
            </tbody>
        </table>

        <h3 class="my-3">Actions</h3>
        <a href="./admin_orders" class="btn btn-primary">Back to Orders</a>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateOrderStatus">
          Update Order Status
        </button>
      </div>
    </div>
    <!-- /.col-lg-4 -->
  </div>
</main>


<!-- Modal update order status -->
<div class="modal fade" id="updateOrderStatus" tabindex="-1" aria-labelledby="updateOrderStatusLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="./update_order_status" method="POST">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateOrderStatusLabel"> Update Order Status</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Pending" <?= $order->getStatus() == "Pending" ? 'selected' : ''  ?>>Pending</option>
                    <option value="Processing" <?= $order->getStatus() == "Processing" ? 'selected' : ''  ?>>Processing</option>
                    <option value="Shipped" <?= $order->getStatus() == "Shipped" ? 'selected' : ''  ?>>Shipped</option>
                    <option value="Delivered" <?= $order->getStatus() == "Delivered" ? 'selected' : ''  ?>>Delivered</option>
                    <option value="Canceled" <?= $order->getStatus() == "Canceled" ? 'selected' : ''  ?>>Canceled</option>
                </select>
            </div>
            <input type="hidden" name="order_id" id="update_order_id" value="<?= $order->getId() ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Order Status</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php require('partials/footer.php') ?>
