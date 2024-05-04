<?php

class User 
{
   // Attributes
   private $id;

   private $email;

   private $password;

   private $first_name;

   private $last_name;

   private $phone;

    private $role;

    // Getters and Setters

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $this->password = $value;
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

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($value)
    {
        $this->phone = $value;
    }
    
    public function getRole()
    {
        return $this->role;
    }

    public function setRole($value)
    {
        $this->role = $value;
    }

    // Methods
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

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
        $statement = $dbh->prepare("SELECT * FROM users WHERE email=?");
        $statement->bindParam(1, $email, PDO::PARAM_STR);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        $statement->execute();
        $user = $statement->fetch();
        if ($user && password_verify($password, $user->getPassword())) {
            Helper::session('user',  ['id' => $user->getId(), 'email' => $user->getEmail(), 'role' => $user->getRole() ]);
            return $user->getId() ;
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
        $req = "INSERT INTO users (email, password, first_name, last_name, phone, role) VALUES (?, ?, ?, ?, ?, ?)";
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

    public static function find($user_id)  {

        $dbh = App::get('dbh');
        $statement = $dbh->prepare("SELECT * FROM users WHERE id = ?");
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        $statement->execute([$user_id]);
        return $statement->fetch();
        
    }

    public function update()
    {
        $dbh = App::get('dbh');
        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "UPDATE users SET  password = ?, first_name = ?, last_name = ?, phone = ? WHERE id = ?";
        $statement = $dbh->prepare($req);
        $statement->bindParam(1, $this->password, PDO::PARAM_STR);
        $statement->bindParam(2, $this->first_name, PDO::PARAM_STR);
        $statement->bindParam(3, $this->last_name, PDO::PARAM_STR);
        $statement->bindParam(4, $this->phone, PDO::PARAM_STR);
        $statement->bindParam(5, $this->id, PDO::PARAM_INT);
        // use exec() because no results are returned
        $statement->execute();
    }

    public static function fetchUsers($page = 1, $roles = ['user'])
    {
        $dbh = App::get('dbh');
        $limit = 15;
        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM users";
        if (count($roles) > 0) {
            $query .= " WHERE role IN ('" . implode("','", $roles) . "')";
        }
        $query .= " ORDER BY id ASC LIMIT $limit OFFSET $offset";
        $statement = $dbh->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    public static function UsersPageCount( $roles = ['user'])
    {
        $dbh = App::get('dbh');
        $limit = 15;
        $query = "SELECT COUNT(*) as count FROM users";
        if (count($roles) > 0) {
            $query .= " WHERE role IN ('" . implode("','", $roles) . "')";
        }
        $statement = $dbh->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $total = $result['count'];
        return ceil($total /  $limit);
    }
 
  
}