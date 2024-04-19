<?php

require_once "app/models/Book.php";
require_once "app/models/User.php";
require_once "app/models/Wishlist.php";
require_once "app/models/Author.php";
require_once "app/models/Category.php";

class WishlistController
{
    public function index()
    {
        $user = User::find($_SESSION['user']['id']);
        $wishlist = Wishlist::fetchByUser($user->getId());
        $books = [];
        foreach($wishlist as $item){
            $book = Book::fetchId($item->getBookId());
            $book->setAuthor(Author::find($book->getAuthorId()));
            $book->setCategory(Category::find($book->getCategoryId()));
            $books[] = $book;
        }
        return Helper::view("wishlist", ['books' => $books]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book_id = $_POST['book_id'];
            $user = User::find($_SESSION['user']['id']);
            $wishlist = new Wishlist();
            $wishlist->setBookId($book_id);
            $wishlist->setUserId($user->getId());
            $wishlist->create();
            Helper::session('message', 'Added to wishlist successfully');
            Helper::redirect('wishlist'); 
        }
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book_id = $_POST['book_id'];
            $user = User::find($_SESSION['user']['id']);
            $wishlist = Wishlist::fetchByUser($user->getId());
            foreach($wishlist as $item){
                if($item->getBookId() == $book_id){
                    $item->delete();
                    Helper::session('message', 'Removed from wishlist successfully');
                    Helper::redirect('wishlist'); 
                }
            }
        }
    }
}