<?php

/**
 * The Author class
 */
require_once "core/database/Model.php";

class Author extends Model {

    protected $id;
    protected $name;

    public static function AuthorsPageCount($limit = 15)
    {
        $dbh = App::get('dbh');
        $query = "SELECT COUNT(*) as total FROM author";
        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return ceil($total / $limit);
    }

    public static function fetchAuthors($page,$limit = 15)
    {
        $dbh = App::get('dbh');
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM author LIMIT :limit OFFSET :offset";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Author');
    }
}