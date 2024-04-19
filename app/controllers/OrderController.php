<?php

require_once "app/models/Order.php";
require_once "app/models/BookOrder.php";
require_once "app/models/Book.php";
require_once "app/models/User.php";
class OrderController
{
  

    public function my_orders()
    {
        $current_user = $_SESSION['user']['id'];
        $my_orders = Order::fetchUserOrders($current_user,$_GET['page'] ?? 1);
        $my_orders_page_count = Order::fetchUserOrdersCount($current_user,$_GET['page'] ?? 1);
        foreach($my_orders as $order){
            $total = 0;
            $order_items = BookOrder::getBooks($order->getId());
            foreach ($order_items as $order_item) {
                $total += $order_item->getPrice() * $order_item->getQty();
            }
            $order->setTotal($total);
        }
   
        return Helper::view("my_orders", ['my_orders' => $my_orders ,'currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $my_orders_page_count]);

    }


        
    public function order_details()
    {
        $order = Order::getOrder($_GET['id']);
        if(!$order){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }
        //check current user is the owner of the order
        if($order->getUserId() != $_SESSION['user']['id']){
                // Redirect to 403 page forbidden
                Helper::redirect('403');
        }

        $order_items = BookOrder::getBooks($order->getId());
        $total = 0;
        foreach ($order_items as $order_item) {
            $order_item->setBook(Book::fetchId($order_item->getBookId()));
            $total += $order_item->getPrice() * $order_item->getQty();
        }
        $order->setTotal($total);
        return Helper::view("order_details", ['order' => $order , 'order_items' => $order_items]);
    }
    
    public function order_admin_details()
    {
        $order = Order::getOrder($_GET['id']);
        if(!$order){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }

        $order_items = BookOrder::getBooks($order->getId());
        $total = 0;
        foreach ($order_items as $order_item) {
            $order_item->setBook(Book::fetchId($order_item->getBookId()));
            $total += $order_item->getPrice() * $order_item->getQty();
        }
        $order->setTotal($total);
        $order->setUser(User::find($order->getUserId()));
        return Helper::view("order_admin_details", ['order' => $order , 'order_items' => $order_items]);
    }
    
    public function update_order_status()
    {
        $order = Order::getOrder($_POST['order_id']);
        if(!$order){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }
        $order->setStatus($_POST['status']);
        $order->save();
        Helper::redirect('admin_orders');
    }

  

    public function index()
    {
       
        $orders = Order::fetchAll($_GET['page'] ?? 1);
        $orders_page_count = Order::OrdersPageCount($_GET['page'] ?? 1 );
        foreach($orders as $order){
            $total = 0;
            $order_items = BookOrder::getBooks($order->getId());
            foreach ($order_items as $order_item) {
                $total += $order_item->getPrice() * $order_item->getQty();
            }
            $order->setTotal($total);
            $order->setUser(User::find($order->getUserId()));
        }
        return Helper::view("admin_orders", ['orders' => $orders, 'totalPages' => $orders_page_count  ,'currentPage' => $_GET['page'] ?? 1]);

    }

}
