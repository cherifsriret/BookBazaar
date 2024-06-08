<?php

require_once "app/models/User.php";
require_once "app/models/Book.php";
require_once "app/models/BookCart.php";

class UserController
{
   
    public function loginForm()
    {
        //logut if already logged in
        unset($_SESSION['user']) ; 
        unset($_SESSION['cart']) ; 
        return Helper::view("login");
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user_id = User::login($email, $password);
           if($user_id)
           {
                $cart_books  = BookCart::fetchUserCart($user_id)??[];
                foreach ($cart_books  as $cart_book) {
                    $book_c = Book::fetchId($cart_book->book_id);
                    $cart_book->book = $book_c;
                }
                $serialized_cart = serialize($cart_books);
                Helper::session('cart', $serialized_cart);
                // Redirect to home page after login
                Helper::session('message', 'Login successful');
                Helper::redirect(''); 
           }
           else
           {
                //redirect to login page with error
                Helper::session('error', 'Invalid username and password OR your account has been banned');
                Helper::redirect('login_form');
           }

        }
    }


    public function registerForm()
    {
        //logut if already logged in
        unset($_SESSION['user']) ; 
        unset($_SESSION['cart']) ; 
        return Helper::view("register");
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];

            if($password != $password_confirmation)
            {
                Helper::session('error', 'Password and password confirmation does not match');
                Helper::redirect('register_form'); 
            }

            $user = new User();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->email = $email;
            $user->phone = $phone;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = 'user';
            $user->create();
            Helper::session('message', 'User created successfully');
            Helper::redirect('login_form');
            
        }
        else
        {
            Helper::session('error', 'Invalid request');
            Helper::redirect('register_form');
        }

    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //redirect to login page
            Helper::redirect('login_form'); 
        }
    }

    public function profile()
    {
        $user = User::fetchId($_SESSION['user']['id']);
        return Helper::view("profile", ['user' => $user]);
    }

    public function editProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::fetchId($_SESSION['user']['id']);
            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];

            if($password != $password_confirmation)
            {
                Helper::session('error', 'Password and password confirmation does not match');
                Helper::redirect('profile'); 
            }
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->phone = $phone;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->update();
            Helper::session('message', 'User updated successfully');
            Helper::redirect('profile');
        }
        else
        {
            Helper::session('error', 'Invalid request');
            Helper::redirect('profile');
        }
    }

    public function list_users()
    {
        $users = User::fetchUsers($_GET['page'] ?? 1);
        $users_page_count = User::UsersPageCount();
        return Helper::view("admin_users", ['users' => $users ,'currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $users_page_count]);
    }

    public function banUser()
    {
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['id'] == $_SESSION['user']['id'])
            {
                Helper::session('error', 'You cannot ban yourself');
                Helper::redirect('admin_users');
            }

            $user = User::fetchId($_POST['id']);
            if(!$user)
            {
                Helper::session('error', 'User not found');
                Helper::redirect('admin_users');
            }
            
            $user->is_banned = 1;
            $user->update();
            Helper::session('message', 'User banned successfully');
            Helper::redirect('admin_users');
            

            
        }
    }

    public function unbanUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::fetchId($_POST['id']);
            if(!$user)
            {
                Helper::session('error', 'User not found');
                Helper::redirect('admin_users');
            }

            $user->is_banned = 0;
            $user->update();
            Helper::session('message', 'User unbanned successfully');
            Helper::redirect('admin_users');
            
        }
    }

    public function edit()
    {
        $user = User::fetchId($_GET['id']);
        return Helper::view("edit_user", ['user' => $user]);
    }

    public function editPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::fetchId($_POST['id']);
            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $password_confirmation = $_POST['password_confirmation'];
            $role = $_POST['role'];

            if($password != $password_confirmation)
            {
                Helper::session('error', 'Password and password confirmation does not match');
                Helper::redirect('admin_users'); 
            }
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->phone = $phone;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = $role;
            $user->update();
            Helper::session('message', 'User updated successfully');
            Helper::redirect('admin_users');
        }
        else
        {
            Helper::session('error', 'Invalid request');
            Helper::redirect('admin_users');
        }
    }

    public function create()
    {
        return Helper::view("create_user");
    }

    public function createPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            $user = new User();
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->email = $email;
            $user->phone = $phone;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = $role;
            $user->create();
            Helper::session('message', 'User created successfully');
            Helper::redirect('admin_users');
            
        }
        else
        {
            Helper::session('error', 'Invalid request');
            Helper::redirect('admin_users');
        }
    }
}
