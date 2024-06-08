<?php

require_once "app/models/Author.php";
require_once "app/models/Category.php";
require_once "app/models/Book.php";
require_once "app/models/Wishlist.php";

class IndexController
{
    
    public function index()
    {
        $latestBooks = Book::latestBooks();
        $featuredBooks = Book::featuredBooks();
        $bestSellerBooks = Book::bestSellerBooks();
        return Helper::view("index", ['latestBooks' => $latestBooks,'featuredBooks' => $featuredBooks,'bestSellerBooks' => $bestSellerBooks]);
    }

    public function all_books()
    {
        $books = Book::fetchAll( $_GET['author'] ?? null, $_GET['category'] ?? null,$_GET['page'] ?? 1 , 12);
        $books_page_count = Book::BooksPageCount( $_GET['author'] ?? null, $_GET['category'] ?? null, 12);
        $all_authors = Author::fetchAll();
        $all_categories = Category::fetchAll();
        return Helper::view("all_books", ['books' => $books, 'current_url' => 'all_books', 'all_authors' => $all_authors , 'all_categories' => $all_categories , 'currentPage' => $_GET['page'] ?? 1 ,'selected_author' =>  $_GET['author'] ?? null ,'selected_category' =>  $_GET['category'] ?? null , 'totalPages' => $books_page_count]);
    }

    public function search()
    {
        $suggestions = [];
        if(isset($_GET['query'])){
            $books = Book::search($_GET['query']);
            foreach($books as $book){
                $suggestions[] = [
                    'title' => $book->title,
                    'data' => $book->id,
                    'image' => $book->image,

                ];
            }
        }
       echo json_encode($suggestions);
       exit;
    }  
    
    public function book_details()
    {
        $book = Book::fetchId($_GET['id']);
        if(!$book){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }
        
        $book->author = Author::fetchId($book->author_id);
        $book->category = Author::fetchId($book->category_id);
        $books_same_author = Book::fetchSameAuthor($book->author_id,$book->id);
        $books_same_category = Book::fetchSameCategory($book->category_id,$book->id);
        if(!isset($_SESSION['user'])){
            return Helper::view("book_details", ['book' => $book , 'books_same_author' => $books_same_author , 'books_same_category' => $books_same_category , 'is_in_wishlist' => false]);
        }
        $current_user = $_SESSION['user']['id'];
        $is_in_wishlist = Wishlist::isInWishlist($book->id , $current_user);
        return Helper::view("book_details", ['book' => $book , 'books_same_author' => $books_same_author , 'books_same_category' => $books_same_category , 'is_in_wishlist' => $is_in_wishlist]);
    }
}
