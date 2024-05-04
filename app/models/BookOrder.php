<?php

/**
 * The BookOrder class
 */
class BookOrder
{

    private $id;

    private $order_id;

    private $book_id;

    private $qty;

    private $price;
    
    private $book;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function setOrderId($value)
    {
        $this->order_id = $value;
    }

    public function getBookId()
    {
        return $this->book_id;
    }

    public function setBookId($value)
    {
        $this->book_id = $value;
    }

    public function getQty()
    {
        return $this->qty;
    }

    public function setQty($value)
    {
        $this->qty = $value;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($value)
    {
        $this->price = $value;
    }

    public function getBook()
    {
        return $this->book;
    }

    public function setBook($value)
    {
        $this->book = $value;
    }

    public static function getBooks($orderId)
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM book_orders WHERE order_id = :order_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'BookOrder');
    }

    public function create()
    {
        $dbh = App::get('dbh');

        $query = "INSERT INTO book_orders (order_id, book_id, qty, price) VALUES (:order_id, :book_id, :qty, :price)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':order_id', $this->order_id);
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':qty', $this->qty);
        $stmt->bindParam(':price', $this->price);
        $stmt->execute();
    }   
   
}