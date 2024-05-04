<?php
    $title = "All Orders Page";
    require('partials/header.php')
?>

<main class="container">

  <h1 class="text-center m-5">All Orders Page</h1>

  <?php
      require('partials/search.php')
  ?>

  <table class="table mt-5">
    <thead>
      <tr>
        <th scope="col">Num</th>
        <th scope="col">Date</th>
        <th scope="col">User</th>
        <th scope="col">Total</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($orders as $order): ?>
      <tr>
        <th scope="row"><?=$order->getId() ?></th>
        <td><?= $order->getDateOrder() ?> </td>
        <td><?= $order->getUser()->getFirstName() ?> <?= $order->getUser()->getLastName() ?> </td>
        <td><?= $order->getTotal() ?>€</td>
        <td><?= $order->getStatus() ?></td>
        <td>
          <a href="./admin_order_details?id=<?= $order->getId() ?>" class="btn btn-primary">Show</a>
        </td>

      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>



  <!-- Add pagination -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">

      <?php 
      $currentParams = $_GET;
      unset($currentParams['page']);

      foreach ($currentParams as $key => $value) {
        $currentParams[$key] = urlencode($value);
      }

      foreach ($currentParams as $key => $value) {
        $currentParams[$key] = "$key=$value";
      }

      $currentParamsString = implode('&', $currentParams);
      ?>
      <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./orders?page=1&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">First</a>
      </li>
      <li class="page-item <?php echo ($currentPage == 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./orders?page=<?php echo $currentPage - 1; ?>&<?= $currentParamsString ?>" tabindex="-1" aria-disabled="true">Previous</a>
      </li>

      <?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
        <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
          <a class="page-link" href="./orders?page=<?php echo $i; ?>&<?= $currentParamsString ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./orders?page=<?php echo $currentPage + 1; ?>&<?= $currentParamsString ?>">Next</a>
      </li>
      <li class="page-item <?php echo ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./orders?page=<?php echo $totalPages; ?>&<?= $currentParamsString ?>">Last</a>
      </li>
    </ul>
  </nav>

</main>


<?php require('partials/footer.php') ?>
