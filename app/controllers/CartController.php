<?php

require_once "app/models/Order.php";
require_once "app/models/BookOrder.php";
require_once "app/models/BookCart.php";
require_once "app/models/Book.php";
class CartController
{
    public function cart()
    {
    
        return Helper::view("cart");
    }

    public function add_to_cart()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $book = Book::fetchId($_POST['book_id']);
                $cart = new BookCart();
                $cart->setBookId($book->getId());
                $cart->setQty($_POST['qty']);
                $cart->setUserId($_SESSION['user']['id']);
                $cart->create();
                Helper::redirect('cart');
            } catch (Exception $e) {
                Helper::session('error', 'Error while adding to cart');
                Helper::redirect('');
            }
        }
        else
        {
            Helper::session('error', 'Invalid request');
            Helper::redirect(''); 
        }

    }

    public function remove_from_cart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
            $cart = BookCart::fetchId($_POST['id']);
            $cart->delete();
            echo json_encode(['status' => 'success']);
        }
        else
        {
            //return ajax response error
            echo json_encode(['status' => 'error']);
        }
    }


    public function update_cart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
            $cart = BookCart::fetchId($_POST['id']);
            $cart->setQty($_POST['qty']);
            $cart->update();
            //return ajax response success
            echo json_encode(['status' => 'success']);
        }
        else
        {
            //return ajax response error
            echo json_encode(['status' => 'error']);
        }
    }

    public function checkoutForm()
    {
      
        return Helper::view("checkout");
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_user = $_SESSION['user']['id'];
            $cart_books = BookCart::fetchUserCart($current_user);
            foreach ($cart_books as $cart_book) {
                $book = Book::fetchId($cart_book->getBookId());
                $cart_book->setBook($book);
            }
            $total = 0;
            foreach ($cart_books as $cart_book) {
                $total += $cart_book->getBook()->getPrice() * $cart_book->getQty();
            }
            $order = new Order();
            $order->setUserId($current_user);
            $order->setTotal($total);
            $order->setStatus('pending');
            $order->setFirstName($_POST['first_name']);
            $order->setLastName($_POST['last_name']);
            $order->setEmail($_POST['email']);
            $order->setPhone($_POST['last_name']);
            $order->setAddress($_POST['address']);
            $order->setDateOrder(date('Y-m-d H:i:s'));
            $order->setCity($_POST['city']);
            $order->setState($_POST['state']);
            $order->setZipCode($_POST['zip']);
         
            $order->create();
            foreach ($cart_books as $cart_book) {
                $book_order = new BookOrder();
                $book_order->setOrderId($order->getId());
                $book_order->setBookId($cart_book->getBookId());
                $book_order->setQty($cart_book->getQty());
                $book_order->setPrice($cart_book->getBook()->getPrice());
                $book_order->create();
                $cart_book->delete();
            }
            Helper::session('message', 'Order placed successfully');
            Helper::redirect('');
        }
        else
        {
            Helper::session('error', 'Invalid request');
            Helper::redirect('checkout_form'); 
        }
    }
}
