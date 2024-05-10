<?php

require_once "core/database/Model.php";
class User extends Model
{
   // Attributes
   protected $id;

   protected $email;

   protected $password;

   protected $first_name;

   protected $last_name;

   protected $phone;

   protected $role;


    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    public function isUser()
    {
        return $this->role == 'user';
    }
    

    public static function login($email, $password)
    {
        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM user WHERE email=:email");
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        $statement->execute();
        $user = $statement->fetch();
        if ($user && password_verify($password, $user->password)) {
            Helper::session('user',  ['id' => $user->id, 'email' => $user->email, 'role' => $user->role ]);
            return $user->id ;
        } else {
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function create()
    {
        $dbh = App::get('dbh');
        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "INSERT INTO user (email, password, first_name, last_name, phone, role) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $dbh->prepare($req);
        $statement->bindParam(1, $this->email, PDO::PARAM_STR);
        $statement->bindParam(2, $this->password, PDO::PARAM_STR);
        $statement->bindParam(3, $this->first_name, PDO::PARAM_STR);
        $statement->bindParam(4, $this->last_name, PDO::PARAM_STR);
        $statement->bindParam(5, $this->phone, PDO::PARAM_STR);
        $statement->bindParam(6, $this->role, PDO::PARAM_STR);
        // use exec() because no results are returned
        $statement->execute();

    }


    public static function fetchUsers($page = 1, $roles = ['user'], $limit = 15)
    {
        $dbh = App::get('dbh');
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM user";
        if (count($roles) > 0) {
            $query .= " WHERE role IN ('" . implode("','", $roles) . "')";
        }
        $query .= " ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $statement = $dbh->prepare($query);
        $statement->bindParam(':limit', $limit, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    public static function UsersPageCount( $roles = ['user'])
    {
        $dbh = App::get('dbh');
        $limit = 15;
        $query = "SELECT COUNT(*) as count FROM user";
        if (count($roles) > 0) {
            $query .= " WHERE role IN (" . implode(',', array_fill(0, count($roles), '?')) . ")";
            $statement = $dbh->prepare($query);
            $statement->execute($roles);
        }
        else {
            $statement = $dbh->prepare($query);
            $statement->execute();
        }
        $result = $statement->fetch();
        $total = $result['count'];
        return ceil($total /  $limit);
    }
  
}