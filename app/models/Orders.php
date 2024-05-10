<?php

/**
 * The Order class
 */
require_once "core/database/Model.php";

class Orders extends Model {

    protected $id;
    protected $user_id;
    protected $status;
    protected $dateOrder;
    protected $first_name;
    protected $last_name;
    protected $address;
    protected $city;
    protected $state;
    protected $zip_code;
    protected $phone;
    protected $email;
    //protected $total;

    public static function fetchUserOrders($userId,$page = 1,$limit = 15)
    {
        $dbh = App::get('dbh');
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Orders');
    }

    public static function fetchUserOrdersCount($userId, $limit = 15)
    {
        $dbh = App::get('dbh');
        $query = "SELECT COUNT(*) as count FROM orders WHERE user_id = :user_id";
        $statement = $dbh->prepare($query);
        $statement->bindParam(':user_id', $userId);
        $statement->execute();
        $result = $statement->fetch();
        $total = $result['count'];
        return ceil($total /  $limit);

    }

    public static function fetchAll($page = 1)
    {
        $dbh = App::get('dbh');
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM orders ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $statement = $dbh->prepare($query);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Orders');
    }

    public static function OrdersPageCount($page = 1){
        $dbh = App::get('dbh');
        $limit = 15;
        $query = "SELECT COUNT(*) as count FROM orders";
        $statement = $dbh->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $total = $result['count'];
        return ceil($total /  $limit);
    }

    public static function getOrder($orderId)
    {
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM orders WHERE id = ?");
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Orders');
        $statement->execute([$orderId]);
        return $statement->fetch();
    }

    public function save()
    {
        $dbh = App::get('dbh');
        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }
      
}