<?php
    $title = "My Orders Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">My Orders Page</h1>

  <?php
      require('partials/search.php')
  ?>

  <table class="table mt-5">
    <thead>
      <tr>
        <th scope="col">Num</th>
        <th scope="col">Date</th>
        <th scope="col">Total</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($my_orders as $order): ?>
        <tr>
          <th scope="row"><?= urlencode($order->id) ?></th>
          <td><?= htmlentities($order->dateOrder) ?></td>
          <td><?= htmlentities($order->total) ?>€</td>
          <td><?= htmlentities($order->status) ?></td>
          <td>
            <a href="./order_details?id=<?= urlencode($order->id) ?>" class="btn btn-primary">Show</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Add pagination -->
  <?php require('partials/pagination.php') ?>
</main>


<?php require('partials/footer.php') ?>
