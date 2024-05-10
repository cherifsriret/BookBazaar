<?php

/**
 * The Category class
 */
require_once "core/database/Model.php";

class Category extends Model 
{
    protected $id;
    protected $name;

    public function getBooks()
    {
        $dbh = App::get('dbh');

        $query = "SELECT * FROM books WHERE category_id = :category_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':category_id', $this->id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Book');
    }

    public static function CategoriesPageCount($limit = 15)
    {
        $dbh = App::get('dbh');
        $query = "SELECT COUNT(*) as total FROM category";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return ceil($total / $limit);
    }

    public static function fetchCategories($page,$limit = 15)
    {
        $dbh = App::get('dbh');
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM category LIMIT :limit OFFSET :offset";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

}