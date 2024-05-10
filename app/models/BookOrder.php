<?php

/**
 * The BookOrder class
 */
require_once "core/database/Model.php";

class BookOrder extends Model {

    protected $id;
    protected $order_id;
    protected $book_id;
    protected $qty;
    protected $price;
    protected $book;

    public static function getBooks($orderId)
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM bookorder WHERE order_id = :order_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'BookOrder');
    }

    public function create()
    {
        $dbh = App::get('dbh');

        $query = "INSERT INTO bookorder (order_id, book_id, qty, price) VALUES (:order_id, :book_id, :qty, :price)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':order_id', $this->order_id);
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':qty', $this->qty);
        $stmt->bindParam(':price', $this->price);
        $stmt->execute();
    }   
   
}