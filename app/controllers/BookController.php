<?php

require_once "app/models/Author.php";
require_once "app/models/Category.php";
require_once "app/models/Book.php";

class BookController
{

    public function index()
    {
        $books = Book::fetchAll('','',$_GET['page'] ?? 1,15);
        foreach($books as $book){
            $book->author = Author::fetchId($book->author_id);
            $book->category = Category::fetchId($book->category_id);
        }
        $books_page_count = Book::BooksPageCount('','',15);
        return Helper::view("admin_books", ['books' => $books ,'current_url' => 'admin_books','currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $books_page_count]);
    }

    public function addForm()
    {
        $authors = Author::fetchAll();
        $categories = Category::fetchAll();
        return Helper::view("create_book", ['authors' => $authors , 'categories' => $categories]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['Title'];
            $author_id = $_POST['Author'];
            $category_id = $_POST['Category'];
            $price = $_POST['Price'];
            $image =  $_POST['Image'];
            $isbn = $_POST['Isbn'];
            $is_featured = $_POST['IsFeatured'] ?? 0;
            if(isset($title) && isset($author_id) && isset( $category_id) && isset($price) && isset($image) && isset($is_featured) && isset($isbn))
            {
                $book = new Book();
                $book->title = $title;
                $book->author_id = $author_id;
                $book->category_id = $category_id;
                $book->price = $price;
                $book->image = $image;
                $book->isbn = $isbn;
                $book->is_featured = $is_featured;
                $book->create();
                Helper::session('message', 'Created successfully');
            }
            else
            {
                Helper::session('error', "Book can't be empty.");
            }
        }
        else
        {
            Helper::session('error', 'Invalid request');
        }
        Helper::redirect('admin_books'); 
    }

    public function edit()
    {
        $book = Book::fetchId($_GET['id']);
        $authors = Author::fetchAll();
        $categories = Category::fetchAll();
        return Helper::view("edit_book", ['book' => $book, 'authors' => $authors , 'categories' => $categories]);
    }

    public function editPost()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = $_POST['Title'];
            $author_id = $_POST['Author'];
            $category_id = $_POST['Category'];
            $price = $_POST['Price'];
            $image =  $_POST['Image'];
            $isbn = $_POST['Isbn'];
            
            $is_featured = $_POST['IsFeatured'] == 'on' ?? 0;
            $id = $_POST['id'];
            if(isset($id) && isset($title) && isset($author_id) && isset( $category_id) && isset($price) && isset($image) && isset($is_featured))
            {
                $book = Book::fetchId($id);
                if(!$book){
                    Helper::session('error', 'Book not found');
                }
                else
                {
                    $book->title = $title;
                    $book->author_id = $author_id;
                    $book->category_id = $category_id;
                    $book->price = $price;
                    $book->image = $image;
                    $book->isbn = $isbn;
                    $book->is_featured = $is_featured;
                    $book->update();
                    Helper::session('message', 'Updated successfully');
                }
            }
            else
            {
                Helper::session('error', "Validation error.");
            }
        }
        else
        {
            Helper::session('error', 'Invalid request');
        }
        Helper::redirect('admin_books'); 
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $book = Book::fetchId($id);
            if($book){
                $is_deleted = $book->delete();
                if($is_deleted === true){
                    Helper::session('message', 'Deleted successfully');
                }
                else
                {
                    Helper::session('error', "You can't delete this book.");
                }
            }
            else
            {
                Helper::session('error', 'Book not found');
            }
        }
        else
        {
            Helper::session('error', 'Invalid request');
        }
        Helper::redirect('admin_books'); 
    }
}
