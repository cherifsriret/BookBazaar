<?php

require_once "app/models/Author.php";
require_once "app/models/Category.php";
require_once "app/models/Book.php";
class BookController
{
    public function index()
    {
        $books = Book::fetchAll($_GET['page'] ?? 1);

        foreach($books as $book){
            $book->setAuthor(Author::find($book->getAuthorId()));
            $book->setCategory(Category::find($book->getCategoryId()));
        }

        $books_page_count = Book::BooksPageCount($_GET['page'] ?? 1);
        return Helper::view("admin_books", ['books' => $books ,'currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $books_page_count]);
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
                $book->setTitle($title);
                $book->setAuthorId($author_id);
                $book->setCategoryId($category_id);
                $book->setPrice($price);
                $book->setImage($image);
                $book->setIsbn($isbn);
                $book->setIsFeatured($is_featured);
                $book->create();
                Helper::session('message', 'Created successfully');
                Helper::redirect('admin_books'); 
            }
            else
            {
                Helper::session('error', "Book can't be empty.");
                Helper::redirect('note_add'); 
            }
        }
    



    }

    public function edit()
    {
        $book = Book::fetchId($_GET['id']);
        $all_authors = Author::fetchAll();
        $all_categories = Category::fetchAll();
        return Helper::view("edit_book", ['book' => $book, 'all_authors' => $all_authors , 'all_categories' => $all_categories]);
    }

    public function edit_post()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = $_POST['title'];
            $author_id = $_POST['author_id'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $image =  $_POST['image'];
            $is_featured = $_POST['is_featured'] ?? 0;
            $id = $_POST['id'];
            
            if(isset($title) && isset($author_id) && isset( $category_id) && isset($price) && isset($image) && isset($is_featured))
            {
                $book = Book::fetchId($id);
                $book->setTitle($title);
                $book->setAuthorId($author_id);
                $book->setCategoryId($category_id);
                $book->setPrice($price);
                $book->setImage($image);
                $book->setIsFeatured($is_featured);
                $book->update();
                Helper::session('message', 'Updated successfully');
                Helper::redirect('admin_books'); 
            }
            else
            {
                Helper::session('error', "Course can't be empty.");
                Helper::redirect('note_add'); 
            }
        }
    }

     

}
