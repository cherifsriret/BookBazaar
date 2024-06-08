<?php
  $currentUser = Helper::getSession('user');
  $cart_books = Helper::getSession('cart') ? unserialize(Helper::getSession('cart')):[];
  $cart_count = count($cart_books)??0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="bg-dark">
      <header class="container d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <div class="col-md-2 mb-2 mb-md-0" bis_skin_checked="1">
          <a href="./" class="d-inline-flex link-body-emphasis text-decoration-none">
            <img src="./assets/logo.png" alt="Logo" class="logo">
          </a>
        </div>
        <?php require('menu.php') ?>
        <div class="col-md-3 text-end" bis_skin_checked="1">
          <div class="dropdown">
            <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              Cart
            </button>
            <?php require('mini_cart.php') ?>
          </div>
        </div>
      </header>
    </div>
   <?php
      $sessionKeys = ['message', 'error'];
      foreach ($sessionKeys as $key) {
          if (isset($_SESSION[$key])) {
              ?>
              <div class="alert alert-<?= $key === 'error' ? 'danger' : 'success' ?>" role="alert">
                <?= htmlentities($_SESSION[$key]) ?>
              </div>
        <?php
              unset($_SESSION[$key]);
          }
      }
    ?>
