<?php

require_once "app/models/Orders.php";
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
                if (!$book) {
                    Helper::session('error', 'Book not found');
                    Helper::redirect('');
                }
                else if(!isset($_POST['qty']) || $_POST['qty'] <= 0)
                {
                    Helper::session('error', 'Invalid quantity');
                    Helper::redirect('');
                }
                else if(!isset($_SESSION['user']))
                {
                    Helper::session('error', 'Please login to add to cart');
                    Helper::redirect('login');
                }
                else {
                    $cart = new BookCart();
                    $cart->book_id = $book->id;
                    $cart->qty = $_POST['qty'];
                    $cart->user_id = $_SESSION['user']['id'];
                    $cart->create();
                    BookCart::setCurrentCartUser( $_SESSION['user']['id']);
                    Helper::session('message', 'Added to cart');
                    Helper::redirect('cart');
                }
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
            if(!$cart)
            {
                //return ajax response error
                echo json_encode(['status' => 'error']);
                return;
            }
            $cart->delete();
            BookCart::setCurrentCartUser( $_SESSION['user']['id']);
            Helger::session('message', 'Removed from cart');
            //return ajax response success
            echo json_encode(['status' => 'success']);
            return;
        }
        else
        {
            //return ajax response error
            echo json_encode(['status' => 'error']);
            return;
        }
    }

    public function update_cart()
    {
      
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
            $cart = BookCart::fetchId($_POST['id']);
            if(!$cart || !isset($_POST['qty']) || $_POST['qty'] <= 0)
            {
                //return ajax response error
                echo json_encode(['status' => 'error']);
                return;
            }
           
            $cart->qty = $_POST['qty'];
            $cart->update();
            BookCart::setCurrentCartUser( $_SESSION['user']['id']);
            var_dump($cart);
            exit;
            Helger::session('message', 'Cart updated');
            //return ajax response success
            echo json_encode(['status' => 'success']);
            return;
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
            if(!isset($current_user))
            {
                Helper::session('error', 'Please login to checkout');
                Helper::redirect('login');
            }
            $cart_books = BookCart::fetchUserCart($current_user);
            if(!$cart_books)
            {
                Helper::session('error', 'Cart is empty');
                Helper::redirect('cart');
            }
            foreach ($cart_books as $cart_book) {
                $book = Book::fetchId($cart_book->book_id);
                if(!$book)
                {
                    Helper::session('error', 'Book not found');
                    Helper::redirect('');
                }
                $cart_book->book = $book;
            }
            $total = 0;
            foreach ($cart_books as $cart_book) {
                $total += $cart_book->book->price * $cart_book->qty;
            }

            $order = new Orders();
            $order->user_id = $current_user;
           // $order->total = $total;
            $order->status = 'pending';
            $order->first_name = $_POST['first_name'];
            $order->last_name = $_POST['last_name'];
            $order->email = $_POST['email'];
            $order->phone = $_POST['last_name'];
            $order->address = $_POST['address'];
            $order->dateOrder = date('Y-m-d H:i:s');
            $order->city = $_POST['city'];
            $order->state = $_POST['state'];
            $order->zip_code = $_POST['zip'];
            $order->create();

            foreach ($cart_books as $cart_book) {
                $book_order = new BookOrder();
                $book_order->order_id = $order->id;
                $book_order->book_id = $cart_book->book_id;
                $book_order->qty = $cart_book->qty;
                $book_order->price = $cart_book->book->price;
                $book_order->create();
                $cart_book->delete();
            }
            BookCart::setCurrentCartUser( $_SESSION['user']['id']);
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
