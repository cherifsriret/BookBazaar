<?php
require_once "app/models/Category.php";
class CategoryController
{
    public function index()
    {
        $categories = Category::fetchCategories($_GET['page'] ?? 1);
        $categories_page_count = Category::CategoriesPageCount($_GET['page'] ?? 1);
        return Helper::view("admin_categories", ['categories' => $categories ,'currentPage' => $_GET['page'] ?? 1 , 'totalPages' => $categories_page_count]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            if(isset($name))
            {
                $category = new Category();
                $category->setName($name);
                $category->create();
                Helper::session('message', 'Created successfully');
                Helper::redirect('admin_categories'); 
            }
            else
            {
                Helper::session('error', "Category name  can't be empty.");
                Helper::redirect('admin_categories'); 
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
                $category = Category::find($id);
                $category->setName($name);
                $category->update();
                Helper::session('message', 'Updated successfully');
                Helper::redirect('admin_categories'); 
            }
            else
            {
                Helper::session('error', "Category name can't be empty.");
                Helper::redirect('admin_categories'); 
            }
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $category = Category::find($id);
            if($category){
                $category->delete();
                Helper::session('message', 'Deleted successfully');
                Helper::redirect('admin_categories'); 
            }
            else
            {
                Helper::session('error', 'Category not found');
                Helper::redirect('admin_categories'); 
            }
        }
    }

}
