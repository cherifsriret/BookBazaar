<?php

require_once "app/models/User.php";
class UserController
{
   
    public function loginForm()
    {
        //logut if already logged in
        unset($_SESSION['user']) ; 
        return Helper::view("login");
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

           if( User::login($email, $password))
           {
                // Redirect to home page after login
                Helper::redirect(''); 
           }
           else
           {
                //redirect to login page with error
                Helper::session('error', 'Invalid username or password');
                Helper::redirect('login_form');
           }

        }
    }


    public function registerForm()
    {
        //logut if already logged in
        unset($_SESSION['user']) ; 
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
            $user->setFirstName($first_name);
            $user->setLastName($last_name);
            $user->setEmail($email);
            $user->setPhone($phone);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            $user->setRole('user');
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
        $user = User::find($_SESSION['user']['id']);
        return Helper::view("profile", ['user' => $user]);
    }

    public function editProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = User::find($_SESSION['user']['id']);
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

            $user->setFirstName($first_name);
            $user->setLastName($last_name);
            $user->setPhone($phone);
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
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
        $users = User::fetchUsers($_GET['page'] ?? 1,['user']);
        $users_page_count = User::UsersPageCount( ['user']);
        return Helper::view("admin_users", ['users' => $users ,'currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $users_page_count]);
    }

    public function list_moderators()
    {
        $users = User::fetchUsers($_GET['page'] ?? 1,['moderator' , 'administrator']);
        $users_page_count = User::UsersPageCount(['moderator' , 'administrator']);
        return Helper::view("admin_moderators", ['users' => $users ,'currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $users_page_count]);
    }

    

}
