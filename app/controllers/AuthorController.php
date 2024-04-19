<?php
require_once "app/models/Author.php";
class AuthorController
{
    public function index()
    {
        $authors = Author::fetchAuthors($_GET['page'] ?? 1);
        $authors_page_count = Author::AuthorsPageCount($_GET['page'] ?? 1);
        return Helper::view("admin_authors", ['authors' => $authors ,'currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $authors_page_count]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            if(isset($name))
            {
                $author = new Author();
                $author->setName($name);
                $author->create();
                Helper::session('message', 'Created successfully');
                Helper::redirect('admin_authors'); 
            }
            else
            {
                Helper::session('error', "Author name  can't be empty.");
                Helper::redirect('admin_authors'); 
            }
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            if(isset($id) && isset($name))
            {
                $author = Author::find($id);
                $author->setName($name);
                $author->update();
                Helper::session('message', 'Updated successfully');
                Helper::redirect('admin_authors'); 
            }
            else
            {
                Helper::session('error', "Author name can't be empty.");
                Helper::redirect('admin_authors'); 
            }
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $author = Author::find($id);
            if($author){
                $author->delete();
                Helper::session('message', 'Deleted successfully');
                Helper::redirect('admin_authors'); 
            }
            else
            {
                Helper::session('error', 'Author not found');
                Helper::redirect('admin_authors'); 
            }
        }
    }

}
