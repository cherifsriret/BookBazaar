<?php

/**
 * The BookCart class
 */
require_once "core/database/Model.php";

class BookCart extends Model {

        protected $id;
        protected $user_id;
        protected $book_id;
        protected $qty;
        protected $book;

        public static function fetchUserCart($userId , $page = 1)
        {

            $dbh = App::get('dbh');
            $query = "SELECT * FROM bookcart WHERE user_id = :user_id";
            $query .= " ORDER BY id ASC";
            $statement = $dbh->prepare($query);
            $statement->bindParam(':user_id', $userId);
    
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'BookCart');

        }

        public static function CartPageCount( $userId){
            $dbh = App::get('dbh');
            $limit = 12;
            $query = "SELECT COUNT(*) as count FROM bookcart WHERE user_id = :user_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $result = $stmt->fetch();
            $total = $result['count'];
            return ceil($total /  $limit);
        }


        public function create()
        {
            $user_id = $this->user_id;
            $book_id = $this->book_id;
            $qty = $this->qty;
            $dbh = App::get('dbh');
            //check if the book is already in the cart then update the qty else insert a new record
            $query = "SELECT * FROM bookcart WHERE user_id = :user_id AND book_id = :book_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();

            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                $qty += $book['qty'];
                $query = "UPDATE bookcart SET qty = :qty WHERE user_id = :user_id AND book_id = :book_id";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':book_id', $book_id);
                $stmt->bindParam(':qty', $qty);
                $stmt->execute();
            } else {
                $query = "INSERT INTO bookcart (user_id, book_id, qty) VALUES (:user_id, :book_id, :qty)";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':book_id', $book_id);
                $stmt->bindParam(':qty', $qty);
                $stmt->execute();
            }
      
        }

        public  function delete()
        {
            $dbh = App::get('dbh');
            $user_id = $this->user_id;
            $book_id = $this->book_id;
            $query = "DELETE FROM bookcart WHERE user_id = :user_id AND book_id = :book_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();
        }

        public function update()
        {
            $dbh = App::get('dbh');
            $query = "UPDATE bookcart SET qty = :qty WHERE id = :id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':qty', $this->qty);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }

        public static function getCartTotal($userId)
        {
            $dbh = App::get('dbh');

            $query = "SELECT SUM(bookcart.qty * books.price) as total FROM bookcart JOIN books ON bookcart.book_id = books.id WHERE user_id = :user_id";
             $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            $total = $stmt->fetch(PDO::FETCH_ASSOC);

            return $total['total'];
        }

        public static function getCartCount($userId)
        {
            $dbh = App::get('dbh');

            $query = "SELECT SUM(qty) as total FROM bookcart WHERE user_id = :user_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_ASSOC);
            return $total['total'];
        }

        public static function setCurrentCartUser($userId)
        {
            $cart_books  = BookCart::fetchUserCart($userId)??[];
            foreach ($cart_books  as $cart_book) {
                $book_c = Book::fetchId($cart_book->book_id);
                $cart_book->book = $book_c;
            }
            $serialized_cart = serialize($cart_books);
            Helper::session('cart', $serialized_cart);
        }

}