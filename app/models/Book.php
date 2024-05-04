<?php
/**
* The Book class
*/
class Book
{

    // Attributes
    private $id;

	private $isbn;

	private $title;

	private $image;

    private $price;

    private $author_id;

    private $author;

    private $category_id;

    private $category;

    private $is_featured;

    // Getters and Setters
    public function getId()
	{
		return $this->id;
	}

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($value)
    {
        $this->isbn = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($value)
    {
        $this->image = $value;
    }

    public function getPrice()
    {
        return $this->price;
    }
    
    public function setPrice($value)
    {
        $this->price = $value;
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function setAuthorId($value)
    {
        $this->author_id = $value;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($value)
    {
        $this->author = $value;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function setCategoryId($value)
    {
        $this->category_id = $value;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($value)
    {
        $this->category = $value;
    }

    public function getIsFeatured()
    {
        return $this->is_featured;
    }

    public function setIsFeatured($value)
    {
        $this->is_featured = $value;
    }

    // Methods

    public static function fetchAll($page = 1, $author = null, $category = null)
    {
        $dbh = App::get('dbh');
        $limit = 12;
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM books WHERE 1 = 1";

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

    public static function BooksPageCount($page = 1, $author = null, $category = null){
        $dbh = App::get('dbh');
        $limit = 12;

        $query = "SELECT COUNT(*) as count FROM books";

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
    
    public static function latestBooks( ){
        $dbh = App::get('dbh');
        $limit =4;
        $statement = $dbh->prepare("SELECT * FROM books ORDER BY id Desc LIMIT $limit");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }

    public static function featuredBooks( ){
        $dbh = App::get('dbh');
        $limit =4;
        $statement = $dbh->prepare("SELECT * FROM books WHERE is_featured = 1 ORDER BY id Desc LIMIT $limit");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }

    public static function mostSellerBooks( ){
        $dbh = App::get('dbh');
        $limit =4;

        $statement = $dbh->prepare("SELECT books.*, SUM(book_orders.qty) AS total_quantity
                                    FROM books
                                    INNER JOIN book_orders ON books.id = book_orders.book_id
                                    INNER JOIN orders ON book_orders.order_id = orders.id
                                    WHERE orders.status = 'Delivered'
                                    GROUP BY books.id
                                    ORDER BY total_quantity DESC
                                    LIMIT $limit");
       
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }

    public static function mostSellBooks( ){
        $dbh = App::get('dbh');
        $limit =4;
        $statement = $dbh->prepare("SELECT * FROM books ORDER BY id Desc LIMIT $limit");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');

    }   

    public static function fetchId($id)
    {
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM books WHERE id = ?");
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Book');
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public static function fetchSameAuthor($author_id, $book_id)
    {
        $dbh = App::get('dbh');
        $limit = 8;
        $statement = $dbh->prepare("SELECT * FROM books WHERE author_id = ? AND id != ? ORDER BY id DESC LIMIT $limit");
        $statement->execute([$author_id, $book_id]);
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public static function fetchSameCategory($category_id, $book_id)
    {
        $dbh = App::get('dbh');
        $limit = 8;
        $statement = $dbh->prepare("SELECT * FROM books WHERE category_id = ? AND id != ? ORDER BY id DESC LIMIT $limit");
        $statement->execute([$category_id, $book_id]);
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public function update()
    {
        $dbh = App::get('dbh');

        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "UPDATE books SET title = ?, isbn = ?, image = ?, author_id = ?, category_id = ?, price = ? , is_featured = ? WHERE id = ?";

        $statement = $dbh->prepare($req);
        $statement->bindParam(1, $this->title, PDO::PARAM_STR);
        $statement->bindParam(2, $this->isbn, PDO::PARAM_STR);
        $statement->bindParam(3, $this->image, PDO::PARAM_STR);
        $statement->bindParam(4, $this->author_id, PDO::PARAM_INT);
        $statement->bindParam(5, $this->category_id, PDO::PARAM_INT);
        $statement->bindParam(6, $this->price, PDO::PARAM_INT);
        $statement->bindParam(7, $this->is_featured, PDO::PARAM_BOOL);
        $statement->bindParam(8, $this->id, PDO::PARAM_INT);
        // use exec() because no results are returned
        $statement->execute();
    }

    public function create()
    {
        $dbh = App::get('dbh');

        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "INSERT INTO books (isbn, title, image, price , author_id, category_id , is_featured) VALUES (?, ?, ?,?, ?, ? , ?)";

        $statement = $dbh->prepare($req);
        $statement->bindParam(1, $this->isbn, PDO::PARAM_STR);
        $statement->bindParam(2, $this->title, PDO::PARAM_STR);
        $statement->bindParam(3, $this->image, PDO::PARAM_STR);
        $statement->bindParam(4, $this->price, PDO::PARAM_INT);
        $statement->bindParam(5, $this->author_id, PDO::PARAM_INT);
        $statement->bindParam(6, $this->category_id, PDO::PARAM_INT);
        $statement->bindParam(7, $this->is_featured, PDO::PARAM_BOOL);

        // use exec() because no results are returned
        $statement->execute();
    }


    public static function search($search)
    {
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM books WHERE title LIKE ?   ORDER BY id DESC LIMIT 5");
        $statement->execute(['%'.$search.'%']);
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public function delete()
    {
        try {
            $dbh = App::get('dbh');
            $query = "DELETE FROM books WHERE id = :id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            return true;
        }
        catch (PDOException $e) {
            return $e->getMessage();
        }

    }
    

}
