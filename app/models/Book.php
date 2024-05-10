<?php
/**
* The Book class
*/
require_once "core/database/Model.php";

class Book extends Model {

    // Attributes
    protected $id;
	protected $isbn;
	protected $title;
	protected $image;
    protected $price;
    protected $author_id;
    protected $category_id;
    protected $is_featured;

    // Methods

    public static function fetchAll( $author = null, $category = null,$page = 1, $limit = 12)
    {
        $dbh = App::get('dbh');
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM book WHERE 1 = 1";

        if ($author != null) {
            $query .= " AND author_id = :author";
        }

        if ($category != null) {
            $query .= " AND category_id = :category";
        }

        $query .= " ORDER BY id ASC LIMIT :limit OFFSET :offset";

        $statement = $dbh->prepare($query);

        if ($author != null) {
            $statement->bindParam(':author', $author, PDO::PARAM_INT);
        }
        if ($category != null) {
            $statement->bindParam(':category', $category, PDO::PARAM_INT);
        }
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }

    public static function BooksPageCount( $author = null, $category = null,$limit = 12){
        $dbh = App::get('dbh');

        $query = "SELECT COUNT(*) as count FROM book";

        if ($author != null && $category != null) {
            $query .= " WHERE author_id = :author AND category_id = :category";
        } elseif ($author != null) {
            $query .= " WHERE author_id = :author";
        } elseif ($category != null) {
            $query .= " WHERE category_id = :category";
        }

        $statement = $dbh->prepare($query);

        if ($author != null && $category != null) {
            $statement->bindParam(':author', $author, PDO::PARAM_INT);
            $statement->bindParam(':category', $category, PDO::PARAM_INT);
        } elseif ($author != null) {
            $statement->bindParam(':author', $author, PDO::PARAM_INT);
        } elseif ($category != null) {
            $statement->bindParam(':category', $category, PDO::PARAM_INT);
        }

        $statement->execute();
        $result = $statement->fetch();
        $total = $result['count'];
        return ceil($total /  $limit);
    }
    
    public static function latestBooks( $limit =4 ){
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM book ORDER BY id Desc LIMIT  :limit");
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }

    public static function featuredBooks($limit =4 ){
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM book WHERE is_featured = 1 ORDER BY id Desc LIMIT  :limit");
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT); 
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }

    public static function mostSellerBooks( $limit =4 ){
        $dbh = App::get('dbh');
       

        $statement = $dbh->prepare("SELECT book.*, SUM(bookorder.qty) AS total_quantity
                                    FROM book
                                    INNER JOIN bookorder ON book.id = bookorder.book_id
                                    INNER JOIN orders ON bookorder.order_id = orders.id
                                    WHERE orders.status = 'Delivered'
                                    GROUP BY book.id
                                    ORDER BY total_quantity DESC
                                    LIMIT :limit");
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
       
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }

    public static function fetchSameAuthor($author_id, $book_id,$limit = 8)
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM book WHERE author_id = :author_id AND id != :book_id  ORDER BY id DESC LIMIT :limit";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public static function fetchSameCategory($category_id, $book_id,$limit = 8)
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM book WHERE category_id = :category_id AND id != :book_id  ORDER BY id DESC LIMIT :limit";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public static function search($search)
    {
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM book WHERE title LIKE ?   ORDER BY id DESC LIMIT 5");
        $statement->execute(['%'.$search.'%']);
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

}
