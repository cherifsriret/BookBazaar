<?php

/**
 * The BookCart class
 */
class BookCart
{

        private $id;

        private $user_id;

        private $book_id;

        private $qty;
        
        private $book;

        public function getId()
        {
            return $this->id;
        }

        public function setId($value)
        {
            $this->id = $value;
        }
        public function getUserId()
        {
            return $this->user_id;
        }

        public function setUserId($value)
        {
            $this->user_id = $value;
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

        public function getBook()
        {
            return $this->book;
        }

        public function setBook($value)
        {
            $this->book = $value;
        }

        public static function fetchUserCart($userId , $page = 1)
        {

            $dbh = App::get('dbh');
            $query = "SELECT * FROM book_cart WHERE user_id = :user_id";
            $query .= " ORDER BY id ASC";
            $statement = $dbh->prepare($query);
            $statement->bindParam(':user_id', $userId);
    
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'BookCart');

        }

        public static function CartPageCount( $userId){
            $dbh = App::get('dbh');
            $limit = 12;
            $query = "SELECT COUNT(*) as count FROM book_cart WHERE user_id = :user_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $result = $stmt->fetch();
            $total = $result['count'];
            return ceil($total /  $limit);
        }

        public static function fetchId($id)
        {
            $dbh = App::get('dbh');
            $query = "SELECT * FROM book_cart WHERE id = :id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'BookCart');
            return $stmt->fetch();
        }

        public function create()
        {

            $user_id = $this->getUserId();
            $book_id = $this->getBookId();
            $qty = $this->getQty();
            $dbh = App::get('dbh');
            //check if the book is already in the cart then update the qty else insert a new record
            $query = "SELECT * FROM book_cart WHERE user_id = :user_id AND book_id = :book_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':book_id', $book_id);
            $stmt->execute();

            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                $qty += $book['qty'];
                $query = "UPDATE book_cart SET qty = :qty WHERE user_id = :user_id AND book_id = :book_id";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':book_id', $book_id);
                $stmt->bindParam(':qty', $qty);
                $stmt->execute();
            } else {
                $query = "INSERT INTO book_cart (user_id, book_id, qty) VALUES (:user_id, :book_id, :qty)";
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
            $userId = $this->getUserId();
            $bookId = $this->getBookId();
            $query = "DELETE FROM book_cart WHERE user_id = :user_id AND book_id = :book_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':book_id', $bookId);
            $stmt->execute();
        }

        public function update()
        {
            $dbh = App::get('dbh');
            $query = "UPDATE book_cart SET qty = :qty WHERE id = :id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':qty', $this->qty);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        }

        public static function getCartTotal($userId)
        {
            $dbh = App::get('dbh');

            $query = "SELECT SUM(book_cart.qty * books.price) as total FROM book_cart JOIN books ON book_cart.book_id = books.id WHERE user_id = :user_id";
             $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            $total = $stmt->fetch(PDO::FETCH_ASSOC);

            return $total['total'];
        }

        public static function getCartCount($userId)
        {
            $dbh = App::get('dbh');

            $query = "SELECT SUM(qty) as total FROM book_cart WHERE user_id = :user_id";
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
                $book_c = Book::fetchId($cart_book->getBookId());
                $cart_book->setBook($book_c);
            }
            $serialized_cart = serialize($cart_books);
            Helper::session('cart', $serialized_cart);
        }

}