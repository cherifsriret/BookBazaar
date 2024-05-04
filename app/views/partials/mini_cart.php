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
    <div class="mb-3"></div>
    <hr class="dropdown-divider">
    <div class="row">
        <a href="./cart" class="btn btn-secondary col m-2">View My Cart</a>
        <a href="./checkout_form" class="btn btn-dark col m-2">Checkout</a>
    </div>
</div>