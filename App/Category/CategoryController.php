<?php


namespace App\Category;


use App\CategoryService;
use App\Controller\AbstractController;
use App\Product\ProductService;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;

class CategoryController extends AbstractController
{
//    /**
//     * @var Route
//     */
//    private $route;

    public function __construct()
    {
//        $this->route = $route;
    }

    /**
     * @route("/sample")
     */
    public function sample()
    {
        echo "hello";
    }

    public function add(Request $request, Response $response,CategoryService $categoryService)
    {
        if ($request->isPost()){

            $category = $categoryService->getDataFromPost($request);
            $inserted = $categoryService->add($category);

            if ($inserted) {
                $response->redirect('/categories/');
            } else {
                die("some insert error");
            }

        }

        return $this->render('categories/add.tpl', []);

    }

    public function delete(Request $request,Response $response,CategoryService $categoryService)
    {
        $id = $request->getIntFromPost('id',false);

        if (!$id){
            die("Error with id");
        }

        $deleted = $categoryService->deleteById($id);
        if ($deleted) {
            $response->redirect('/categories/');
        } else {
            die("some error with delete");
        }
    }

    public function edit(Request $request,Response $response,CategoryService $categoryService)
    {
        $id = $request->getIntFromGet('id',null);
        if (is_null($id)){
            $id = $this->route->getParam('id');
        }

        $category = [];

        if ($id) {
            $category = $categoryService->getById($id);
        }

        if ($request->isPost()){

            /*$id = $_POST['id'];*/

            $category = $categoryService->getDataFromPost($request);
            $edited = $categoryService->updateById($id, $category);


            if ($edited) {
                $response->redirect('/categories/');
            } else {
                die("some edit error");
            }

        }

        $this->render('categories/edit.tpl', [
            'category'=>$category,
        ]);
    }

    public function list(CategoryService $categoryService)
    {
        $categories = $categoryService->getList();


        $this->render('categories/index.tpl', [
            'categories'=>$categories,
        ]);
    }

    public function view(ProductService $productService, CategoryService $categoryService, Request $request)
    {
        $category_id = $request->getIntFromGet('id',null);
        if (is_null($category_id)){
            $category_id = $this->route->getParam('id') ?? null;
        }

        $category = $categoryService->getById($category_id);
        $products = $productService->getListByCategory($category_id);

        $this->render('categories/view.tpl', [
            'products'=>$products,
            'current_category'=>$category,
        ]);
    }

}