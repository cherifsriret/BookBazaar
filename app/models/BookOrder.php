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

    public static function getBooks($orderId)
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM bookorder WHERE order_id = :order_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'BookOrder');
    }


   
}