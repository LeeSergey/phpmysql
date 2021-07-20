<?php

use App\Category;
use App\Product;
use App\ProductImage;
use App\Request;
use App\Response;

if (Request::isPost()){

    $product = Product::getDataFromPost();
    $productId = Product::add($product);

    /* Загрузка изображений по урл */
    $imageUrl = $_POST['image_url'];
    ProductImage::uploadImagesByUrl($productId , $imageUrl);

    /* Загрузка изображений c локального диска */
    $uploadImages = $_FILES['images'] ?? [];
    ProductImage::uploadImages($productId, $uploadImages);

    if ($productId) {
        Response::redirect('/products/list');
    } else {
        die("some insert error");
    }

}

$categories = Category::getList();


$smarty->assign('categories',$categories);
$smarty->display('products/add.tpl');
/**
 * 1. Проверять был ли отправлен POST запрос на эту страницу
 * 2. Полученные данные записывать в базу данных
 * 3. Делать редирект на главную страницу
 */

?>