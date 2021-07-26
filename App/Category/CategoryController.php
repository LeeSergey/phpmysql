<?php


namespace App\Category;


use App\Category;
use App\Product;
use App\Renderer;
use App\Request;
use App\Response;

class CategoryController
{
    /**
     * @var array
     */
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function add()
    {
        if (Request::isPost()){

            $category = Category::getDataFromPost();
            $inserted = Category::add($category);

            if ($inserted) {
                Response::redirect('/categories/');
            } else {
                die("some insert error");
            }

        }

        Renderer::getSmarty()->display('categories/add.tpl');
    }

    public function delete()
    {
        $id = Request::getIntFromPost('id',false);

        if (!$id){
            die("Error with id");
        }

        $deleted = Category::deleteById($id);

        if ($deleted) {
            Response::redirect('/categories/');
        } else {
            die("some error with delete");
        }
    }

    public function edit()
    {
        $id = Request::getIntFromGet('id',null);

        if (is_null($id)){
            $id = $this->params['id'] ?? null;
        }

        $category = [];

        if ($id) {
            $category = Category::getById($id);
        }

        if (Request::isPost()){

            /*$id = $_POST['id'];*/

            $category = Category::getDataFromPost();
            $edited = Category::updateById($id, $category);


            if ($edited) {
                Response::redirect('/categories/');
            } else {
                die("some edit error");
            }

        }
        Renderer::getSmarty()->assign('category',$category);
        Renderer::getSmarty()->display('categories/edit.tpl');
    }

    public function list()
    {
        $categories = Category::getList();

        Renderer::getSmarty()->assign('categories',$categories);
        Renderer::getSmarty()->display('categories/index.tpl');
    }

    public function view()
    {
        $category_id = Request::getIntFromGet('id',null);
        if (is_null($category_id)){
            $category_id = $this->params['id'] ?? null;
        }

        $category = Category::getById($category_id);
        $products = Product::getListByCategory($category_id);

        Renderer::getSmarty()->assign('products',$products);
        Renderer::getSmarty()->assign('current_category',$category);
        Renderer::getSmarty()->display('categories/view.tpl');
    }

}