<?php

/**
 * The Wishlist class
 */
require_once "core/database/Model.php";

class Wishlist extends Model {

    protected $id;

    protected $user_id;

    protected $book_id;


    public function isWislisted($bookId, $userId)
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM wishlist WHERE book_id = :book_id AND user_id = :user_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }   

    public function create()
    {

        $user_id = $this->user_id;
        $book_id = $this->book_id;
         $dbh = App::get('dbh');
        //check if the book is already in the cart then update the qty else insert a new record
        $query = "SELECT * FROM wishlist WHERE user_id = :user_id AND book_id = :book_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':book_id', $book_id);
        $stmt->execute();

        $wishlist = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$wishlist) {
          
            $query = "INSERT INTO wishlist (user_id, book_id) VALUES (:user_id, :book_id)";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();
        }
  
    }

    public function removeFromWishlist($bookId, $userId)
    {
        $dbh = App::get('dbh');

        $query = "DELETE FROM wishlist WHERE book_id = :book_id AND user_id = :user_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }

    public static function fetchByUser($userId)
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM wishlist WHERE user_id = :user_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Wishlist');
    }

}