<?php

namespace App\Product;

use App\CategoryService;
use App\Category\CategoryModel;
use App\Controller\AbstractController;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;

class ProductController extends AbstractController
{

//    /**
//     * @var Route
//     */
//    private $route;

    public function __construct(/*Route $route*/)
    {
//        $this->route = $route;
    }

    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return mixed
     *
     * @route("/product_list")
     */
    public function list(Request $request, ProductRepository $productRepository)
    {
        $current_page = $request->getIntFromGet('p', 1);

        $limit = 10;
        $offset = ($current_page - 1) * $limit;

        $productsCount = $productRepository->getListCount();
        $pagesCount = ceil($productsCount/$limit);

        $products = $productRepository->getList($limit,$offset);

        return $this->render('products/index.tpl', [
            'pages_count' => $pagesCount,
            'products' => $products,
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param ProductService $productService
     * @param ProductRepository $productRepository
     * @param ProductImageService $productImageService
     * @param CategoryService $categoryService
     * @return mixed
     *
     * @route("/product_edit/{id}")
     */
    public function edit(
        Request $request,
        Response $response,
        ProductService $productService,
        ProductRepository $productRepository,
        ProductImageService $productImageService,
        CategoryService $categoryService)
    {
        $productId = $request->getIntFromGet('id',null);
        if (is_null($productId)){
            $productId = $this->route->getParam('id');
        }
        $product = [];

        if ($productId) {
            $product = $productRepository->getById($productId);
        }

        if ($request->isPost()){
            $productData = $productService->getDataFromPost($request);

            $product->setName($productData['name']);
            $product->setArticle($productData['article']);
            $product->setDescription($productData['description']);
            $product->setAmount($productData['amount']);
            $product->setPrice($productData['price']);

            $categoryId = $productData['category_id'] ?? 0;
            if ($categoryId){
                $categoryData = $categoryService->getById($categoryId);
                $categoryName = $categoryData['name'];
                $category = new CategoryModel($categoryName);
                $category->setId($categoryId);

                $product->setCategory($category);
            }

            $product = $productRepository->save($product);
            $edited = $productService->updateById($productId, $productData);

            /* Загрузка изображений по урл */
            $imageUrl = trim($request->getStrFromPost('image_url'));
            $productImageService->uploadImagesByUrl($productId , $imageUrl);

            /* Загрузка изображений c локального диска */
            $uploadImages = $_FILES['images'] ?? [];
            $productImageService->uploadImages($productId, $uploadImages);

            $response->redirect('/products/');

        }

        $categories = $categoryService->getList();

        return $this->render('products/edit.tpl', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param ProductImageService $productImageService
     * @param ProductRepository $productRepository
     * @param ProductService $productService
     * @param CategoryService $categoryService
     * @return mixed
     * @throws Exception
     */
    public function add(Request $request, Response $response, ProductImageService $productImageService, ProductRepository $productRepository, ProductService $productService, CategoryService $categoryService)
    {
        if ($request->isPost()){

            $productData = $productService->getDataFromPost($request);
            $product = $productRepository->getProductFromArray($productData);
            $product = $productRepository->save($product);

            $productId = $product->getId();

            /* Загрузка изображений по урл */
            $imageUrl = trim($request->getStrFromPost('image_url'));
            $productImageService->uploadImagesByUrl($productId , $imageUrl);

            /* Загрузка изображений c локального диска */
            $uploadImages = $_FILES['images'] ?? [];
            $productImageService->uploadImages($productId, $uploadImages);

            if ($productId) {
                $response->redirect('/products/');
            } else {
                die("some insert error");
            }

        }

        $categories = $categoryService->getList();
        $product = new ProductModel('', 0 , 0);
        $product->setId(0);

        $category = new CategoryModel('');
        $category->setId(0);

        $product->setCategory($category);

        return $this->render('products/add.tpl', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function delete(Request $request,Response $response, ProductService $productService)
    {
        $id = $request->getIntFromPost('id',false);

        if (!$id){
            die("Error with id");
        }

        $deleted = $productService->deleteById($id);

        if ($deleted) {
            $response->redirect('/products/');
        } else {
            die("some error with delete");
        }
    }

    public function deleteImage(Request $request, ProductImageService $productImageService)
    {
        $productImageId = $request->getIntFromPost('product_image_id',false);

        if (!$productImageId){
            die("error with id");
        }

        $productImageService->deleteById($productImageId);
        die('ok');
    }
    
}