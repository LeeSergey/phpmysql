<?php

namespace App\Product;

use App\Category;
use App\Category\CategoryModel;
use App\Product;
use App\ProductImage;
use App\Renderer;
use App\Request;
use App\Response;

class ProductController
{

    /**
     * @var array
     */
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function list()
    {
        $current_page = Request::getIntFromGet('p', 1);

        $limit = 10;
        $offset = ($current_page - 1) * $limit;

        $products_count = Product::getListCount();

        $pages_count = ceil($products_count/$limit);

        $productRepository = new ProductRepository();
        $products = $productRepository->getList($limit,$offset);

        Renderer::getSmarty()->assign('pages_count', $pages_count);
        Renderer::getSmarty()->assign('products',$products);
        Renderer::getSmarty()->display('products/index.tpl');
    }

    public function edit()
    {
        $productId = Request::getIntFromGet('id',null);
        if (is_null($productId)){
            $productId = $this->params['id'] ?? null;
        }
        $product = [];

        $productRepository = new ProductRepository();

        if ($productId) {
            $product = $productRepository->getById($productId);
        }

        if (Request::isPost()){
            $productData = Product::getDataFromPost();

            $product->setName($productData['name']);
            $product->setArticle($productData['article']);
            $product->setDescription($productData['description']);
            $product->setAmount($productData['amount']);
            $product->setPrice($productData['price']);

            $categoryId = $productData['category_id'] ?? 0;
            if ($categoryId){
                $categoryData = Category::getById($categoryId);
                $categoryName = $categoryData['name'];
                $category = new CategoryModel($categoryName);
                $category->setId($categoryId);

                $product->setCategory($category);
            }

            $product = $productRepository->save($product);
            $edited = Product::updateById($productId, $productData);

            /* Загрузка изображений по урл */
            $imageUrl = $_POST['image_url'];
            ProductImage::uploadImagesByUrl($productId , $imageUrl);

            /* Загрузка изображений c локального диска */
            $uploadImages = $_FILES['images'] ?? [];
            ProductImage::uploadImages($productId, $uploadImages);

            Response::redirect('/products/');

        }

        $categories = Category::getList();

        Renderer::getSmarty()->assign('product',$product);
        Renderer::getSmarty()->assign('categories',$categories);
        Renderer::getSmarty()->display('products/edit.tpl');
    }

    public function add()
    {
        if (Request::isPost()){

            $productData = Product::getDataFromPost();
            $productRepository = new ProductRepository();
            $product = $productRepository->getProductFromArray($productData);

            $product = $productRepository->save($product);

            $productId = $product->getId();

            /* Загрузка изображений по урл */
            $imageUrl = $_POST['image_url'];
            ProductImage::uploadImagesByUrl($productId , $imageUrl);

            /* Загрузка изображений c локального диска */
            $uploadImages = $_FILES['images'] ?? [];
            ProductImage::uploadImages($productId, $uploadImages);

            if ($productId) {
                Response::redirect('/products/');
            } else {
                die("some insert error");
            }

        }

        $categories = Category::getList();
        $product = new Product\ProductModel('', 0 , 0);
        $product->setId(0);

        $category = new CategoryModel('');
        $category->setId(0);

        $product->setCategory($category);

        Renderer::getSmarty()->assign('categories',$categories);
        Renderer::getSmarty()->assign('product',$product);
        Renderer::getSmarty()->display('products/add.tpl');
    }

    public function delete()
    {
        $id = Request::getIntFromPost('id',false);

        if (!$id){
            die("Error with id");
        }

        $deleted = Product::deleteById($id);

        if ($deleted) {
            Response::redirect('/products/');
        } else {
            die("some error with delete");
        }
    }

    public function deleteImage()
    {
        $productImageId = Request::getIntFromPost('product_image_id',false);

        if (!$productImageId){
            die("error with id");
        }

        $deleted = ProductImage::deleteById($productImageId);
        die('ok');
        /*if ($deleted) {
            Response::redirect('/products/list');
        } else {
            die("some error with delete");
        }*/
    }
    
}