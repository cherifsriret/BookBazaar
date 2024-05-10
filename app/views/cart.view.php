<?php
    $title = "Cart Page";
    require('partials/header.php')
?>
<main class="container">
    
    <h1 class="text-center m-5">Cart Page</h1>

    <?php
        require('partials/search.php')
    ?>
    <div class="row">
        <div class="col-lg-8">
            <h3 class="main-heading">My Cart</h3>
            <div class="table-cart">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_cart = 0; ?>
                        <?php foreach($cart_books as $cart_book): 
                            $total_cart += htmlentities($cart_book->book->price)  * htmlentities($cart_book->qty);
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <img src="<?= htmlentities($cart_book->book->image) ?>" alt="" height= 100>
                                    <div class="name-product flex-1">
                                        <?= htmlentities($cart_book->book->title) ?>
                                        <?= htmlentities($cart_book->book->isbn) ?>
                                    </div>
                                    <div class="price">
                                        <?= htmlentities($cart_book->book->price) ?>€
                                    </div>
                                </div>
                            </td>
                            <td class="product-count">
                                <input type="number" class="cart-qty form-control" value="<?= htmlentities($cart_book->qty) ?>" data-id="<?= urlencode($cart_book->id) ?>">
                            </td>
                            <td>
                                <button title="Remove" class="px-2 cart-remove btn btn-danger" data-id="<?= urlencode($cart_book->id) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">
                                <h5>Sub total : <?= $total_cart ?>€ </h5>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.table-cart -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="cart-totals bg-body-secondary px-4 py-5 rounded-3">
                <h3>Cart Totals</h3>
                <form action="#" method="get" accept-charset="utf-8">
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
                                <td class="price-total"><?= $total_cart ?>€ </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center m-5">
                        <a href="./checkout_form" class="btn btn-dark" title="">Proceed to Checkout</a>
                    </div>
                    <!-- /.btn-cart-totals -->
                </form>
                <!-- /form -->
            </div>
            <!-- /.cart-totals -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
</main>

<?php require('partials/footer.php') ?>
