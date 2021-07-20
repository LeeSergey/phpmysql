<?php

use App\Category;
use App\Product;
use App\ProductImage;
use App\Request;
use App\Response;

$productId = Request::getIntFromGet('id');
$product = [];

if ($productId) {
    $product = Product::getById($productId);
}

if (Request::isPost()){

    $productData = Product::getDataFromPost();
    $edited = Product::updateById($productId, $productData);

    /* Загрузка изображений по урл */
    $imageUrl = $_POST['image_url'];
    ProductImage::uploadImagesByUrl($productId , $imageUrl);

    /* Загрузка изображений c локального диска */
    $uploadImages = $_FILES['images'] ?? [];
    ProductImage::uploadImages($productId, $uploadImages);

    Response::redirect('/products/list');

}

$categories = Category::getList();

$smarty->assign('product',$product);
$smarty->assign('categories',$categories);
$smarty->display('products/edit.tpl');

/**
 * 1. Проверять был ли отправлен POST запрос на эту страницу
 * 2. Полученные данные записывать в базу данных
 * 3. Делать редирект на главную страницу
 */

?>