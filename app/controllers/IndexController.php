<?php

require_once "app/models/Author.php";
require_once "app/models/Category.php";
require_once "app/models/Book.php";

class IndexController
{
    
    public function index()
    {
        $latestBooks = Book::latestBooks();
        $featuredBooks = Book::featuredBooks();
        $mostSellerBooks = Book::mostSellerBooks();
        return Helper::view("index", ['latestBooks' => $latestBooks,'featuredBooks' => $featuredBooks,'mostSellerBooks' => $mostSellerBooks]);
    }

    public function all_books()
    {
        $books = Book::fetchAll($_GET['page'] ?? 1, $_GET['author'] ?? null, $_GET['category'] ?? null);
        $books_page_count = Book::BooksPageCount($_GET['page'] ?? 1 , $_GET['author'] ?? null, $_GET['category'] ?? null);
        $all_authors = Author::fetchAll();
        $all_categories = Category::fetchAll();
        return Helper::view("all_books", ['books' => $books, 'all_authors' => $all_authors , 'all_categories' => $all_categories , 'currentPage' => $_GET['page'] ?? 1 ,'selected_author' =>  $_GET['author'] ?? null ,'selected_category' =>  $_GET['category'] ?? null , 'totalPages' => $books_page_count]);
    }

    public function search()
    {
        $sugesstions = [];
        if(isset($_GET['query'])){
            $books = Book::search($_GET['query']);
            foreach($books as $book){
                $sugesstions[] = [
                    'title' => $book->getTitle(),
                    'data' => $book->getId(),
                    'image' => $book->getImage(),

                ];
            }
        }
       echo json_encode($sugesstions);
       exit;
    }  
    
    public function book_details()
    {
        $book = Book::fetchId($_GET['id']);
        if(!$book){
            // Redirect to 404 page not found
            Helper::redirect('404');
        }
        $book->setAuthor(Author::find($book->getAuthorId()));
        $book->setCategory(Category::find($book->getCategoryId()));
        $books_same_author = Book::fetchSameAuthor($book->getAuthorId(),$book->getId());
        $books_same_category = Book::fetchSameCategory($book->getCategoryId(),$book->getId());
        return Helper::view("book_details", ['book' => $book , 'books_same_author' => $books_same_author , 'books_same_category' => $books_same_category]);
    }
}
