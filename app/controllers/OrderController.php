<?php

require_once "app/models/Orders.php";
require_once "app/models/BookOrder.php";
require_once "app/models/Book.php";
require_once "app/models/User.php";

class OrderController
{

    public function my_orders()
    {
        $limit = 15;
        $current_user = $_SESSION['user']['id'];
        $my_orders = Orders::fetchUserOrders($current_user,$_GET['page'] ?? 1, $limit);
        $my_orders_page_count = Orders::fetchUserOrdersCount($current_user, $limit);
        foreach($my_orders as $order){
            $total = 0;
            $order_items = BookOrder::getBooks($order->id);
            foreach ($order_items as $order_item) {
                $total += $order_item->price * $order_item->qty;
            }
            $order->total = $total;
        }
        return Helper::view("my_orders", ['my_orders' => $my_orders ,'current_url' => 'my_orders','currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $my_orders_page_count]);
    }
        
    public function order_details()
    {
        $order = Orders::fetchId($_GET['id']);
        if(!$order){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }
        //check current user is the owner of the order
        if($order->user_id != $_SESSION['user']['id']){
            // Redirect to 403 page forbidden
            Helper::redirect('403');
        }
        $order_items = BookOrder::getBooks($order->id);
        $total = 0;
        foreach ($order_items as $order_item) {
            $order_item->book = Book::fetchId($order_item->book_id);
            $total += $order_item->price * $order_item->qty;
        }
        $order->total = $total;
        return Helper::view("order_details", ['order' => $order , 'order_items' => $order_items]);
    }
    
    public function order_admin_details()
    {
        $order = Orders::fetchId($_GET['id']);
        if(!$order){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }
        $order_items = BookOrder::getBooks($order->id);
        $total = 0;
        foreach ($order_items as $order_item) {
            $order_item->book = Book::fetchId($order_item->book_id);
            $total += $order_item->price * $order_item->qty;
        }
        $order->total = $total;
        $order->user = User::fetchId($order->user_id);
        return Helper::view("order_admin_details", ['order' => $order , 'order_items' => $order_items]);
    }
    
    public function update_order_status()
    {
        $order = Orders::fetchId($_POST['order_id']);
        if(!$order){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }
        $order->status = $_POST['status'];
        $order->save();
        Helper::redirect('admin_orders');
    }

    public function index()
    {
       
        $orders = Orders::fetchAll($_GET['page'] ?? 1);
        $orders_page_count = Orders::OrdersPageCount($_GET['page'] ?? 1 );
        foreach($orders as $order){
            $total = 0;
            $order_items = BookOrder::getBooks($order->id);
            foreach ($order_items as $order_item) {
                $total += $order_item->price * $order_item->qty;
            }
            $order->total = $total;
            $order->user = User::fetchId($order->user_id);
        }
        return Helper::view("admin_orders", ['orders' => $orders, "current_url" => "orders",'totalPages' => $orders_page_count  ,'currentPage' => $_GET['page'] ?? 1]);
    }
}
