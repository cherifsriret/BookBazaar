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
            }
            else
            {
                Helper::session('error', "Category name  can't be empty.");
            }
        }
        else
        {
            Helper::session('error', 'Invalid request');
        }
        Helper::redirect('admin_categories'); 
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            if(isset($id) && isset($name))
            {
                $category = Category::find($id);
                if(!$category){
                    Helper::session('error', 'Category not found');
                }
                else
                {
                    $category->setName($name);
                    $category->update();
                    Helper::session('message', 'Updated successfully');
                }
            }
            else
            {
                Helper::session('error', "Category name can't be empty.");
            }
        }
        else
        {
            Helper::session('error', 'Invalid request');
        }
        Helper::redirect('admin_categories');
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $category = Category::find($id);
            if($category){
                $is_deleted = $category->delete();
                if($is_deleted === true){
                    Helper::session('message', 'Deleted successfully');
                }
                else
                {
                    Helper::session('error', "You can't delete this category.");
                }
            }
            else
            {
                Helper::session('error', 'Category not found');
            }
        }
        else
        {
            Helper::session('error', 'Invalid request');
        }
        Helper::redirect('admin_categories');
    }
}
