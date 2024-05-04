<?php

/**
 * The Author class
 */
class Author
{

    private $id;
    
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public static function fetchAll()
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM authors";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Author');
    }

    public static function find($id)
    {
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM authors WHERE id = ?");
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Author');
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public  function create()
    {
        $dbh = App::get('dbh');

        $query = "INSERT INTO authors (name) VALUES (:name)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->execute();

        $id = $dbh->lastInsertId();
        return Author::find($id);
    }

    public function update()
    {
        $dbh = App::get('dbh');

        $query = "UPDATE authors SET name = :name WHERE id = :id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function delete()
    {
        try {
            $dbh = App::get('dbh');
            $query = "DELETE FROM authors WHERE id = :id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            return true;
        }
        catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public static function AuthorsPageCount()
    {
        $dbh = App::get('dbh');
        $limit = 15;
        $query = "SELECT COUNT(*) as total FROM authors";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return ceil($total / $limit);
    }

    public static function fetchAuthors($page)
    {
         $limit = 15;
        $dbh = App::get('dbh');
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM authors LIMIT $limit OFFSET $offset";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Author');
    }
}