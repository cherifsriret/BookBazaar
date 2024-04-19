<?php

/**
 * The Order class
 */

class Order
{

        private $id;
        private $user_id;
        private $total;
        private $status;
        private $dateOrder;
        private $first_name;
        private $last_name;
        private $address;
        private $city;
        private $state;
        private $zip_code;
        private $phone;
        private $email;

        private $books;

        private $user;

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

        public function getTotal()
        {
            return $this->total;
        }

        public function setTotal($value)
        {
            $this->total = $value;
        }

        public function getStatus()
        {
            return $this->status;
        }

        public function setStatus($value)
        {
            $this->status = $value;
        }

        public function getDateOrder()
        {
            return $this->dateOrder;
        }

        public function setDateOrder($value)
        {
            $this->dateOrder = $value;
        }

        public function getFirstName()
        {
            return $this->first_name;
        }

        public function setFirstName($value)
        {
            $this->first_name = $value;
        }

        public function getLastName()
        {
            return $this->last_name;
        }

        public function setLastName($value)
        {
            $this->last_name = $value;
        }

        public function getAddress()
        {
            return $this->address;
        }

        public function setAddress($value)
        {
            $this->address = $value;
        }

        public function getCity()
        {
            return $this->city;
        }

        public function setCity($value)
        {
            $this->city = $value;
        }

        public function getState()
        {
            return $this->state;
        }

        public function setState($value)
        {
            $this->state = $value;
        }

        public function getPhone()
        {
            return $this->phone;
        }

        public function setPhone($value)
        {
            $this->phone = $value;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function setEmail($value)
        {
            $this->email = $value;
        }

        public function getUser()
        {
            return $this->user;
        }

        public function setUser($value)
        {
            $this->user = $value;
        }


       
        public function getBooks()
        {
            return $this->books;
        }

        public function setBooks($value)
        {
            $this->books = $value;
        }

        public function getZipCode()
        {
            return $this->zip_code;
        }

        public function setZipCode($value)
        {
            $this->zip_code = $value;
        }


        public function create()
        {
            $dbh = App::get('dbh');

            $query = "INSERT INTO orders (user_id, dateOrder, status, first_name, last_name , email , phone , address , city ,state , zip_code ) VALUES (:user_id, NOW(), 'pending', :first_name, :last_name , :email , :phone , :address , :city , :state , :zip_code)";
            $stmt = $dbh->prepare($query);

            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':state', $this->state);
            $stmt->bindParam(':zip_code', $this->zip_code);

            $stmt->execute();

            $this->id = $dbh->lastInsertId();
        }

        public static function fetchUserOrders($userId,$page = 1)
        {
            $dbh = App::get('dbh');
            $limit = 15;
            $offset = ($page - 1) * $limit;
            $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Order');
        }

        public static function fetchUserOrdersCount($userId)
        {
            $limit = 15;
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
            $query = "SELECT * FROM orders ORDER BY id ASC LIMIT $limit OFFSET $offset";
            $statement = $dbh->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Order');
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
            $statement->setFetchMode(PDO::FETCH_CLASS, 'Order');
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