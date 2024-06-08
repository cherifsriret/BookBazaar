<div class="dropdown-menu p-4">
    <h5>Items added  To Cart</h5>
    <hr class="dropdown-divider">
    <div class="mb-3">
        <?php if($cart_count == 0): ?>
                <p>No items in cart</p>
        <?php else: ?>
            <?php foreach($cart_books  as $cart_book): ?>
                <div class="d-flex justify-content-between">
                    <img src="<?= htmlentities($cart_book->book->image) ?>" alt="" height= 50>
                    <span><?= htmlentities($cart_book->book->title) ?></span>
                    <span><?= htmlentities($cart_book->qty) ?>x<?= htmlentities($cart_book->book->price) ?>€</span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="mb-3"></div>
    <hr class="dropdown-divider">
    <div class="row">
        <a href="./cart" class="btn btn-secondary col m-2">View My Cart</a>
        <?php if (count($cart_books) > 0): ?>
            <a href="./checkout_form" class="btn btn-dark col m-2">Checkout</a>
        <?php endif; ?>
       
    </div>
</div>