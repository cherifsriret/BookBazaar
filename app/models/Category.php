<?php

/**
 * The Category class
 */

class Category
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

        $query = "SELECT * FROM categories";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
    }


    
    public static function find($id)
    {
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM categories WHERE id = ?");
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public  function create()
    {
        $dbh = App::get('dbh');

        $query = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->execute();
        $id = $dbh->lastInsertId();
        return Category::find($id);
    }

    public function update()
    {
        $dbh = App::get('dbh');

        $query = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function delete()
    {
        $dbh = App::get('dbh');

        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function getBooks()
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM books WHERE category_id = :category_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':category_id', $this->id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
    }



    public static function CategoriesPageCount()
    {
        $dbh = App::get('dbh');
        $limit = 15;
        $query = "SELECT COUNT(*) as total FROM categories";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return ceil($total / $limit);
    }

    public static function fetchCategories($page)
    {
         $limit = 15;
        $dbh = App::get('dbh');
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM categories LIMIT $limit OFFSET $offset";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

}