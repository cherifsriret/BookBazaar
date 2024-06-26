<?php

$router->define([

  // public routes
  ''=> ["action" => 'IndexController' , "is_protected" => false], //GET
  'index'=> ["action" => 'IndexController' , "is_protected" => false], //GET
  'all_books'=> ["action" => 'IndexController@all_books' , "is_protected" => false], //Post
  'book_details'=> ["action" => 'IndexController@book_details' , "is_protected" => false], //Post
  'search'=>  ["action" => 'IndexController@search' , "is_protected" => false], //Post

  // user routes
  'cart'=>  ["action" => 'CartController@cart' , "is_protected" => true ,'role'=>['user','moderator', 'administrator']], //Post
  'add_to_cart'=>  ["action" => 'CartController@add_to_cart' , "is_protected" => true ,'role'=>['user','moderator', 'administrator']], //Post
  'update_cart'=>  ["action" => 'CartController@update_cart' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'remove_from_cart'=>  ["action" => 'CartController@remove_from_cart' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'checkout_form'=>  ["action" => 'CartController@checkoutForm' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'checkout'=>  ["action" => 'CartController@checkout' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'my_orders'=>  ["action" => 'OrderController@my_orders' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'order_details'=> ["action" => 'OrderController@order_details' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'wishlist'=>  ["action" => 'WishlistController' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'add_to_wishlist'=>  ["action" => 'WishlistController@add_to_wishlist' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'remove_from_wishlist'=>  ["action" => 'WishlistController@remove_from_wishlist' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
 
  // auth routes
  'login_form'=> ["action" => 'UserController@loginForm' , "is_protected" => false], //GET
  'login'=> ["action" => 'UserController@login' , "is_protected" => false], //Post
  'register_form'=> ["action" => 'UserController@registerForm' , "is_protected" => false], //GET
  'register'=> ["action" => 'UserController@register' , "is_protected" => false], //Post
  'logout'=>  ["action" => 'UserController@logout' , "is_protected" => true ,'role'=>['user','moderator', 'administrator']], //Post
  'profile'=>  ["action" => 'UserController@profile' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post
  'edit_profile'=>  ["action" => 'UserController@editProfile' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //Post

  // admin authors routes
  'admin_authors' => ["action" => 'AuthorController' , "is_protected" => true ,'role'=>['moderator', 'administrator']], //GET
  'add_author' => ["action" => 'AuthorController@create' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'update_author' => ["action" => 'AuthorController@update' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'delete_author' => ["action" => 'AuthorController@delete' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST

  // admin categories routes
  'admin_categories' => ["action" => 'CategoryController' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'add_category' => ["action" => 'CategoryController@create' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'update_category' => ["action" => 'CategoryController@update' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'delete_category' => ["action" => 'CategoryController@delete' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET

  // admin books routes
  'admin_books' => ["action" => 'BookController' , "is_protected" => true ,'role'=>['moderator', 'administrator']], //GET 
  'add_book_form' => ["action" => 'BookController@addForm' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'book_add' => ["action" => 'BookController@add' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'book_edit' => ["action" => 'BookController@edit' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'book_edit_post' => ["action" => 'BookController@editPost' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'book_delete' => ["action" => 'BookController@delete' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST

  // admin orders routes
  'admin_orders' => ["action" => 'OrderController' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'admin_order_details' => ["action" => 'OrderController@order_admin_details' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'update_order_status' => ["action" => 'OrderController@update_order_status' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST

  // admin users routes
  'admin_users' => ["action" => 'UserController@list_users' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'ban_user' => ["action" => 'UserController@banUser' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'unban_user' => ["action" => 'UserController@unbanUser' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'edit_user' => ["action" => 'UserController@edit' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'edit_user_post' => ["action" => 'UserController@editPost' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST
  'create_user' => ["action" => 'UserController@create' , "is_protected" => true,'role'=>['moderator', 'administrator']], //GET
  'create_user_post' => ["action" => 'UserController@createPost' , "is_protected" => true,'role'=>['moderator', 'administrator']], //POST

  //wishlist routes
  'add_to_wishlist' => ["action" => 'WishlistController@add' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //POST
  'remove_from_wishlist' => ["action" => 'WishlistController@remove' , "is_protected" => true,'role'=>['user','moderator', 'administrator']], //POST

  //error routes
  '404' => ["action" => 'ErrorController@notFound' , "is_protected" => false], //GET
  '403' => ["action" => 'ErrorController@forbidden' , "is_protected" => false], //GET
  '500' => ["action" => 'ErrorController@serverError' , "is_protected" => false], //GET
]);
